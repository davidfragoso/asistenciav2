@extends('layouts.app')
@section('content')


<section class="section">
  <div class="section-header">
    <h3 class="page__heading">Asistencias</h3>
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
        <div class="table-responsive">
          <table class="table table-striped mt-2">
            <thead style="background-color:#6777ef">
              <tr>
                <th style="color:#fff;">ID</th>
                <th style="color:#fff;">Nombre</th>
                <th style="color:#fff;">Fecha</th>
                <th style="color:#fff;">Hora Entrada</th>
                <th style="color:#fff;">Hora salida</th>
                <th style="color:#fff;">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($attendances as $attendance)
              <tr>
                <td>{{ $attendance->id }}</td>
                <td>{{ $attendance->user ? $attendance->user->name : '-' }}</td>
                <td>{{ $attendance->created_at->format('d/m/Y') }}

                </td>
                <td>
                  @if ($attendance->late)
                  <span class="badge badge-danger">Tarde</span>
                  @endif
                  {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i:s') : '-' }}
                </td>
                <td>
                  @if ($attendance->overtime)
                  <span class="badge badge-success">Hora extra</span>
                  @endif
                  {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i:s') : '-' }}
                </td>
                <td>
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"
                    data-attendance-id="{{ $attendance->id }}">Eliminar</button>

                </td>

                <!-- Modal de confirmación -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Eliminar Asistencia</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        ¿Estás seguro de que deseas eliminar esta asistencia?
                      </div>
                      <div class="modal-footer">
                        <form id="deleteForm" action="{{ route('attendances.destroy', $attendance->id) }}" method="POST"
                          class="d-inline-block">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                          <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <!-- Centramos la paginacion a la derecha -->
      <div class="pagination justify-content-end">
        {!! $attendances->links() !!}
      </div>
    </div>
  </div>
</section>
@endsection