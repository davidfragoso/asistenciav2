@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Crear Departamento</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-warning" href="{{ route('departments.create') }}">Nuevo</a>

                        <table class="table table-striped mt-2">
                            <thead style="background-color:#6777ef">
                                <th style="color:#fff">ID</th>
                                <th style="color:#fff">Nombre</th>
                                <th style="color:#fff">Descripción</th>
                                <th style="color:#fff">Jefe de departamento</th>
                                <th style="color:#fff">No. Empleados</th>
                                <th style="color:#fff">Acciones</th>
                            </thead>
                            <tbody>
                                @foreach ($departments as $department)
                                <tr>
                                    <td>{{ $department->id }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>{{ $department->description }}</td>
                                    <td>
                                        @if(!empty($department->jefe))
                                        {{ $department->jefe->name }}
                                        @else
                                        Sin jefe
                                        @endif
                                    </td>
                                    <td>{{ $department->num_empleados }}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{ route('departments.edit',$department->id) }}">Editar</a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['departments.destroy', $department->id], 'style' => 'display:inline']) !!}
                                        {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <!-- Centramos la paginacion a la derecha -->
                        <div class="pagination justify-content-end">
                            {!! $departments->links() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
