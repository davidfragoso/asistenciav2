<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;

use Illuminate\Http\Request;
use Carbon\Carbon;


class AttendanceController extends Controller
{
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

    public function assign()
    {
        $attendance = new Attendance();
        $attendance->employee_id = auth()->user()->id;
        $attendance->status = 'present';
        $now = Carbon::now();
        $attendance->check_in = $now;
        $attendance->date = $now->toDateString();
        $attendance->save();

        return redirect()->back();
    }

    public function leave()
    {
        $attendance = new Attendance();
        $attendance->employee_id = auth()->user()->id;
        $attendance->status = 'left';
        $now = Carbon::now();
        $attendance->check_out = $now;
        $attendance->date = $now->toDateString();
        $attendance->save();

        return redirect()->back();
    }

    public function markAttendance(Request $request)
    {
        $id = $request->input('attendance_id');
        $attendance = Attendance::where('employee_id', $id)
            ->whereDate('check_in', '=', Carbon::today()->toDateString())->first();

        if ($attendance) {
            return redirect()->back()->with('error', 'La asistencia ya ha sido registrada para hoy.');
        } else {
            $attendance = new Attendance();
            $attendance->employee_id = $id;
            $attendance->status = 'present';
            $attendance->check_in = Carbon::now();
            $attendance->date = Carbon::today();
            $attendance->save();
            return redirect()->back()->with('success', '¡Asistencia marcada!');
        }
    }


    public function markDeparture(Request $request)
{
    $id = $request->input('attendance_id');
    $attendance = Attendance::where('attendance_id', $id)
        ->whereNotNull('employee_id')
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
