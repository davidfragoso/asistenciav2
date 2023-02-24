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
                        <form method="POST" action="{{route('schedules.update',$schedules->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="start_time">Hora de Inicio</label>
                                <input type="time" class="form-control" id="start_time" name="start_time"
                                    value="{{$schedules->start_time}}" required>
                            </div>
                            <div class="form-group">
                                <label for="end_time">Hora de Fin</label>
                                <input type="time" class="form-control" id="end_time" name="end_time"
                                    value="{{$schedules->end_time}}" required>
                            </div>
                            <div class="form-group">
                                <label for="day_of_week">Día de la Semana</label>
                                <select class="form-control" id="day_of_week" name="day_of_week" required>
                                    <option value="Lunes" {{$schedules->day_of_week == "Lunes" ? 'selected' : ''}}>Lunes
                                    </option>
                                    <option value="Martes" {{$schedules->day_of_week == "Martes" ? 'selected' :
                                        ''}}>Martes</option>
                                    <option value="Miercoles" {{$schedules->day_of_week == "Miercoles" ? 'selected' :
                                        ''}}>Miércoles
                                    </option>
                                    <option value="Jueves" {{$schedules->day_of_week == "Jueves" ? 'selected' :
                                        ''}}>Jueves</option>
                                    <option value="Viernes" {{$schedules->day_of_week == "Viernes" ? 'selected' :
                                        ''}}>Viernes
                                    </option>
                                    <option value="Sabado" {{$schedules->day_of_week == "Sabado" ? 'selected' :
                                        ''}}>Sábado</option>
                                    <option value="Domingo" {{$schedules->day_of_week == "Domingo" ? 'selected' :
                                        ''}}>Domingo
                                    <option value="L-V" {{$schedules->day_of_week == "L-V" ? 'selected' : ''}}>L-V
                                    <option value="L-S" {{$schedules->day_of_week == "L-S" ? 'selected' : ''}}>L-S

                                    <option value="L-D" {{$schedules->day_of_week == "L-D" ? 'selected' : ''}}>L-D


                                    </option>
                                </select>
                            </div>
                            <form action="{{ route('schedules.update', $schedules->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection