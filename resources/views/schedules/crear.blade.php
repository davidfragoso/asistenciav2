@extends('layouts.app')
@section('content')

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Horarios</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Editar Horario</h4>

                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{route('schedules.store')}}">
                            @csrf
                            <div class="form-group">
                                <label for="start_time">Hora de Inicio</label>
                                <input type="time" class="form-control" id="start_time" name="start_time" required>
                            </div>
                            <div class="form-group">
                                <label for="end_time">Hora de Fin</label>
                                <input type="time" class="form-control" id="end_time" name="end_time" required>
                            </div>
                            <div class="form-group">
                                <label for="day_of_week">Día de la Semana</label>
                                <select class="form-control" id="day_of_week" name="day_of_week" required>
                                    <option value="Lunes">Lunes</option>
                                    <option value="Martes">Martes</option>
                                    <option value="Miercoles">Miércoles</option>
                                    <option value="Jueves">Jueves</option>
                                    <option value="Viernes">Viernes</option>
                                    <option value="Sabado">Sábado</option>
                                    <option value="Domingo">Domingo</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</section>

@endsection