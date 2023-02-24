<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;

use Illuminate\Http\Request;
use Carbon\Carbon;


class AttendanceController extends Controller
{
    protected $user_id;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user_id = auth()->id();
            return $next($request);
        });
    }
    public function index()
    {
        $attendances = Attendance::paginate(5);
        return view('attendances.index', compact('attendances'));
    }

    public function create()
    {
        return view('attendances.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'check_in' => 'required',
            'check_out' => 'required',
            'late' => 'required',
            'overtime' => 'required'
        ]);

        $attendance = new Attendance();
        $attendance->employee_id = auth()->user()->id;
        $attendance->status = 'present';
        $attendance->check_in = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('check_in'));
        $attendance->check_out = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('check_out'));
        $attendance->late = $request->input('late');
        $attendance->overtime = $request->input('overtime');
        $attendance->save();

        return redirect()->route('attendances.index')
            ->with('success', 'Asistencia registrada correctamente.');
    }

    public function edit(Attendance $attendance)
    {
        return view('attendances.edit', compact('attendance'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'check_in' => 'required',
            'check_out' => 'required',
            'late' => 'required',
            'overtime' => 'required'
        ]);

        $attendance->check_in = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('check_in'));
        $attendance->check_out = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('check_out'));
        $attendance->late = $request->input('late');
        $attendance->overtime = $request->input('overtime');
        $attendance->save();

        return redirect()->route('attendances.index')
            ->with('success', 'Asistencia actualizada correctamente.');
    }


    public function destroy($id)
    {
        $attendance = Attendance::find($id);

        $attendance->delete();
        session()->flash('message', 'Asistencia eliminada correctamente.');
        session()->flash('alert-type', 'danger');

        return redirect()->route('attendances.index');
    }

    public function markAttendance(Request $request)
{
    $user_id = auth()->id();
    $attendance_id = User::where('id', $user_id)->pluck('attendance_id')->first();

    $attendance = Attendance::where('employee_id', $user_id)
        ->whereDate('check_in', Carbon::today()->toDateString())
        ->first();

    if ($attendance) {
        return redirect()->back()->with('error', 'La asistencia ya ha sido registrada para hoy.');
    } else {
        $request->validate([
            'id' => 'required'
        ]);

        $input_attendance_id = $request->input('id');

        if ($attendance_id != $input_attendance_id) {
            return view('tu_vista')->with('error', 'El ID de asistencia no es válido.');
        }
        

        $attendance = new Attendance();
        $attendance->employee_id = $user_id;
        $attendance->attendance_id = $attendance_id;
        $attendance->status = 'present';
        $attendance->check_in = Carbon::now();
        $attendance->date = Carbon::today();
        $attendance->save();
        return redirect()->back()->with('success', '¡Asistencia marcada!');
    }
}

    

    public function markDeparture(Request $request)
    {
        $user_id = auth()->id();
        $attendance_id = $request->input('attendance_id');

        $attendance = Attendance::where('attendance_id', $attendance_id)
            ->where('employee_id', $user_id)
            ->whereDate('check_in', Carbon::today()->toDateString())
            ->first();

        if ($attendance && $attendance->check_out == null) {
            $attendance->status = 'left';
            $attendance->check_out = Carbon::now();
            $attendance->save();
            return redirect()->back()->with('success', '¡Salida marcada!');
        } else {
            return redirect()->back()->with('error', 'No se encontró asistencia registrada para este código de entrada o ya se ha registrado la salida.');
        }
    }
}
