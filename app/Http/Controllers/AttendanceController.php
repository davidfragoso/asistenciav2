<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
        $attendance->status = 'presente';
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
            $existing_attendance->status = 'retirado';
            $existing_attendance->save();
            $button_text = 'Entrada'; // Actualizar el texto del botón a 'Entrada'
            $message = '¡Salida registrada correctamente!';
        } else {
            // Si no hay una entrada de asistencia existente, actualizar el estado de la última asistencia del usuario (si existe)
            $last_attendance = Attendance::where('user_id', $user_id)
                ->orderBy('id', 'desc')
                ->first();

            if ($last_attendance && $last_attendance->date == Carbon::today()->toDateString() && $last_attendance->status == 'presente') {
                $last_attendance->status = 'retirado';
                $last_attendance->save();
            }

            $attendance_id = User::where('id', $user_id)->value('attendance_id');

            // Crear un nuevo registro de asistencia
            $attendance = new Attendance;
            $attendance->user_id = $user_id;
            $attendance->employee_id = $user_id;
            $attendance->check_in = Carbon::now();
            $attendance->status = 'presente';
            $attendance->date = Carbon::now()->toDateString();
            $attendance->attendance_id = $attendance_id; // asignar el valor de attendance_id
            $attendance->save();

            // Obtener el valor de attendance_id del usuario actual
            $user = User::find($user_id);
            $attendance->attendance_id = $user->attendance_id;

            $attendance->save();

            // Consultar la base de datos para obtener el registro de asistencia recién guardado
            $saved_attendance = Attendance::where('id', $attendance->id)->first();

            // Verificar si el valor de attendance_id es correcto
            if ($saved_attendance->attendance_id == $attendance->attendance_id) {
                $request->session()->put('attendance_id', $attendance->id);
                $button_text = 'Salida'; // Actualizar el texto del botón a 'Salida'
                $message = '¡Asistencia marcada correctamente!';
            } else {
                // Si el valor de attendance_id es incorrecto, mostrar un mensaje de error
                return redirect()->back()->with('error', 'Ha ocurrido un error al marcar la asistencia. Por favor, inténtelo de nuevo.');
            }
        }

        return redirect()->back()->with('success', $message)
            ->with('button_text', $button_text);
    }
    public function attendanceChartData()
    {
        $users = User::all();
        $attendances = Attendance::all();
        $today = Carbon::today()->toDateString();

        $todayData = $attendances->filter(function ($attendance) use ($today) {
            return $attendance->date === $today;
        });

        $attendanceCount = $todayData->filter(function ($attendance) {
            return $attendance->status === "presente";
        })->count();

        $retiredCount = $todayData->filter(function ($attendance) {
            return $attendance->status === 'retirado';
        })->count();

        $absentCount = $users->reject(function ($user) use ($todayData) {
            return $todayData->contains('user_id', $user->id);
        })->count();

        $lateCount = $todayData->filter(function ($attendance) {
            return $attendance->status === 'presente' && Carbon::parse($attendance->time)->gt(Carbon::parse('09:00:00'));
        })->count();

        return response()->json([
            'attendanceCount' => $attendanceCount,
            'absentCount' => $absentCount,
            'retiredCount' => $retiredCount,
            'lateCount' => $lateCount
        ]);
    }
}
