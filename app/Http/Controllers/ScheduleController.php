<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;





class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = Schedule::paginate(5);
        return view('schedules.index', compact('schedules'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('schedules.crear');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $schedules = new Schedule;
        $schedules->start_time = $request->input('start_time');
        $schedules->end_time = $request->input('end_time');
        $schedules->day_of_week = $request->input('day_of_week');
        $schedules->save();
        session()->flash('message', 'Horario creado correctamente.');
        session()->flash('alert-type', 'success');

        return redirect()->route('schedules.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedules = Schedule::find($id);
        return view('schedules.editar', compact('schedules'));
    }





    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'day_of_week' => 'required'
        ]);

        $schedule = Schedule::find($id);
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->day_of_week = $request->day_of_week;

        $schedule->save();
        session()->flash('message', 'Horario actualizado correctamente.');
        session()->flash('alert-type', 'primary');

        return redirect()->route('schedules.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedule = Schedule::find($id);
    
        $schedule->delete();
        session()->flash('message', 'Horario eliminado correctamente.');
        session()->flash('alert-type', 'danger');
    
        return redirect()->route('schedules.index');
    }
    
}
