@extends('layouts.app')
@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Horarios</h3>
        @if (session('message'))
        <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show right-alert" role="alert">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            $(document).ready(function() {
            $(".alert").fadeTo(3000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });
        });
        </script>
        @endif

    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <!-- Botón para abrir el modal -->
                <a class="btn btn-warning" data-toggle="modal" data-target="#createScheduleModal">
                    Nuevo
                </a>
    
                <table class="table table-striped mt-2">
                    <thead style="background-color:#6777ef">
                        <tr>
                            <th style="color:#fff;">ID</th>
                            <th style="color:#fff;">ID Departamento</th>
                            <th style="color:#fff;">Departamento</th>
                            <th style="color:#fff;">Hora Inicio</th>
                            <th style="color:#fff;">Hora Fin</th>
                            <th style="color:#fff;">Día semana</th>
                            <th style="color:#fff;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules ?? '' as $schedule)
                        <tr>
                            <td>{{ $schedule->id }}</td>
                            <td>{{ $schedule->department_id }}</td>
                            <td>{{ $schedule->department }}</td>
                            <td>{{ $schedule->start_time }}</td>
                            <td>{{ $schedule->end_time }}</td>
                            <td>{{ $schedule->day_of_week }}</td>
                            <td>
                                <a href="{{ route('schedules.edit', $schedule->id) }}"
                                    class="btn btn-warning">Editar</a>
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#deleteModal" data-schedule-id="{{ $schedule->id }}">Eliminar</button>
                            </td>
                        </tr>
                        @endforeach
    
                        <!-- Modal de confirmación -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Eliminar Horario</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que deseas eliminar este horario?
                                    </div>
                                    <div class="modal-footer">
                                        <form id="deleteForm" action="#" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
    
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">

                <!-- Centramos la paginacion a la derecha -->
                <div class="pagination justify-content-end">
                    {!! $schedules ->links() !!}
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
                                        <input type="time" class="form-control" id="start_time" name="start_time"
                                            required>
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
    </div>
</section>
@endsection