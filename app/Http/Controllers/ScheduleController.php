<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use App\Models\Department;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('department')
            ->join('departments', 'fixed_schedule.department_id', '=', 'departments.id')
            ->select('fixed_schedule.*', 'departments.name as department')
            ->paginate(10);
        $departments = Department::paginate(5);
        return view('schedules.index', compact('schedules', 'departments'));
    }


    public function create()
    {
        $departments = Department::all();
        return view('schedules.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'day_of_week' => 'required',
            'department_id' => 'required|exists:departments,id'
        ]);

        $department = Department::findOrFail($validated['department_id']);

        $schedule = new Schedule;
        $schedule->start_time = $validated['start_time'];
        $schedule->end_time = $validated['end_time'];
        $schedule->day_of_week = $validated['day_of_week'];
        $schedule->department_id = $department->id;
        $schedule->department = $department->name;
        $schedule->save();

        return redirect()->route('schedules.index')->with('success', 'Horario creado exitosamente');
    }

    public function show(Schedule $schedule)
    {
        return view('schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        $departments = Department::all();
        return view('schedules.editar', compact('schedule', 'departments'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'day_of_week' => 'required',
            'department_id' => 'required|exists:departments,id'
        ]);

        $department = Department::findOrFail($validated['department_id']);

        $schedule->start_time = $validated['start_time'];
        $schedule->end_time = $validated['end_time'];
        $schedule->day_of_week = $validated['day_of_week'];
        $schedule->department_id = $department->id;
        $schedule->department = $department->name;
        $schedule->save();

        return redirect()->route('schedules.index')->with('success', 'Horario actualizado exitosamente');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Horario eliminado exitosamente');
    }
}
