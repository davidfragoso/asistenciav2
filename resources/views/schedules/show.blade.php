@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">{{ $department->name }}</h3>
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
                            <th style="color:#fff;">Hora Inicio</th>
                            <th style="color:#fff;">Hora Fin</th>
                            <th style="color:#fff;">Día semana</th>
                            <th style="color:#fff;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($department->schedules as $schedule)
                        <tr>
                            <td>{{ $schedule->id }}</td>
                            <td>{{ $schedule->start_time }}</td>
                            <td>{{ $schedule->end_time }}</td>
                            <td>{{ $schedule->day_of_week }}</td>
                            <td>
                                <a href="{{ route('schedules.edit', $schedule->id) }}"
                                    class="btn btn-warning">Editar</a>
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#deleteModal" data-scheduleid="{{ $schedule->id }}">Eliminar</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- Modal para crear horarios -->

@include('schedules.create')
<!-- Modal para eliminar horarios -->

@include('schedules.delete')

@endsection