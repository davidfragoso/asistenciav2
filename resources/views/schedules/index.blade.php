@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Horarios</h3>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <!-- Botón para abrir el modal -->
                <a class="btn btn-warning" data-toggle="modal" data-target="#createScheduleModal"
                    data-backdrop="static">
                    Nuevo
                </a>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Departamento</th>
                                <th>Día de la semana</th>
                                <th>Hora de inicio</th>
                                <th>Hora de fin</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departments as $department)
                            <tr>
                                <td colspan="5" class="table-dark">
                                    <h4>{{ $department->name }}</h4>
                                </td>
                            </tr>
                            @foreach($department->schedules as $schedule)
                            <tr>
                                <td></td>
                                <td>{{ $schedule->day_of_week }}</td>
                                <td>{{ $schedule->start_time }}</td>
                                <td>{{ $schedule->end_time }}</td>
                                <td>
                                    <a href="{{ route('schedules.edit', ['department' => $department->id, 'schedule' => $schedule->id]) }}"
                                        class="btn btn-sm btn-primary">Editar</a>
                                    <form
                                        action="{{ route('schedules.destroy', ['department' => $department->id, 'schedule' => $schedule->id]) }}"
                                        method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $schedules->links() }}
            </div>
            <!-- Modal -->
            <div class="modal fade" id="createScheduleModal" tabindex="-1" role="dialog"
                aria-labelledby="createScheduleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createScheduleModalLabel">Crear nuevo horario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Aquí va el formulario para ingresar los datos del horario -->
                            <form method="POST" action="{{route('schedules.store')}}">
                                @csrf
                                <div class="form-group">
                                    <label for="department_id">Departamento</label>
                                    <select name="department_id" id="department_id" class="form-control">
                                        <option value="#">--Selecciona un departamento--</option>
                                        @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="start_time">Hora de Inicio</label>
                                    <input type="time" class="form-control" id="start_time" name="start_time" required>
                                </div>
                                <div class="form-group">
                                    <label for="end_time">Hora Fin</label>
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
                                        <option value="L-V">L-V</option>
                                        <option value="L-S">L-S</option>
                                        <option value="L-D">L-D</option>


                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection