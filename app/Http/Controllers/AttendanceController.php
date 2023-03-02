<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Department;
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
        $attendances = Attendance::with('user')->paginate(10);
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
        $attendance->user_id = auth()->user()->id;
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

    public function markAttendance(Request $request)
    {
        $user_id = auth()->id();

        // Verificar si ya hay una asistencia registrada para el usuario en la fecha actual
        $existing_attendance = Attendance::where('user_id', $user_id)
            ->whereDate('date', Carbon::today()->toDateString())
            ->first();

        if ($existing_attendance) {
            // Si ya hay una entrada de asistencia, actualizar la hora de salida y el estado a "left"
            $existing_attendance->check_out = Carbon::now();
            $existing_attendance->status = 'left';
            $existing_attendance->save();
            $button_text = 'Entrada'; // Actualizar el texto del botón a 'Entrada'
            return redirect()->back()->with('success', '¡Salida registrada correctamente!')
                ->with('button_text', $button_text);
        }

        // Si no hay una entrada de asistencia existente, actualizar el estado de la última asistencia del usuario (si existe)
        $last_attendance = Attendance::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->first();

        if ($last_attendance && $last_attendance->date == Carbon::today()->toDateString() && $last_attendance->status == 'present') {
            $last_attendance->status = 'left';
            $last_attendance->save();
        }

        // Crear un nuevo registro de asistencia
        $attendance = new Attendance;
        $attendance->user_id = $user_id; // Actualizar esta línea para asignar el valor de user_id
        $attendance->employee_id = $user_id;
        $attendance->check_in = Carbon::now();
        $attendance->status = 'present';
        $attendance->date = Carbon::now()->toDateString();
        $attendance->save();
        $button_text = 'Salida'; // Actualizar el texto del botón a 'Salida'

        return redirect()->back()->with('success', '¡Asistencia marcada correctamente!')
            ->with('button_text', $button_text);
    }
}
