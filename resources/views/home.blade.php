@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Dashboard</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-xl-4">

                                <div class="card bg-c-blue order-card">
                                    <div class="card-block">
                                        <h5>Usuarios</h5>
                                        @php
                                        use App\Models\User;
                                        $cant_usuarios = User::count();
                                        @endphp
                                        <h2 class="text-right"><i
                                                class="fa fa-users f-left"></i><span>{{$cant_usuarios}}</span></h2>
                                        <p class="m-b-0 text-right"><a href="/usuarios" class="text-white">Ver más</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4">
                                <div class="card bg-c-green order-card">
                                    <div class="card-block">
                                        <h5>Roles</h5>
                                        @php
                                        use Spatie\Permission\Models\Role;
                                        $cant_roles = Role::count();
                                        @endphp
                                        <h2 class="text-right"><i
                                                class="fa fa-user-lock f-left"></i><span>{{$cant_roles}}</span></h2>
                                        <p class="m-b-0 text-right"><a href="/roles" class="text-white">Ver más</a></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4">
                                <div class="card bg-c-pink order-card">
                                    <div class="card-block">
                                        <h5>Asistencias
                                        </h5>
                                        @php
                                        use App\Models\Attendance;
                                        $cant_attendance = Attendance::count();
                                        @endphp
                                        <h2 class="text-right"><i
                                                class="fa fa-user-clock f-left"></i><span>{{$cant_attendance}}</span>
                                        </h2>
                                        <p class="m-b-0 text-right"><a href="/attendances" class="text-white">Ver
                                                más</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-4">
                                <div class="card bg-c-orange order-card">
                                    <div class="card-block">
                                        <h5>Horarios</h5>
                                        @php
                                        use App\Models\Schedule;
                                        $cant_schedules = Schedule::count();
                                        @endphp
                                        <h2 class="text-right"><i
                                                class="fa fa-calendar f-left"></i><span>{{$cant_schedules}}</span></h2>
                                        <p class="m-b-0 text-right"><a href="/schedules" class="text-white">Ver más</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row col-lg-12">
                                <!-- Agregar un canvas para el gráfico de asistencias -->
                                <div class="col-md-3">
                                    <div class="card-block">
                                        <h5>Estatus</h5>
                                        <canvas id="attendance-chart"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card-block">
                                        <h5>Puntualidad</h5>
                                        <canvas id="late-chart"></canvas>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    // hacer la petición a la ruta del controlador
fetch('/attendance-chart-data')
.then(response => response.json())
.then(data => {
    // crear la gráfica de asistencias
new Chart(document.getElementById('attendance-chart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: ['Presente', 'Ausente', 'Retirado'],
        datasets: [{
            data: [data.attendanceCount, data.absentCount, data.retiredCount],
            backgroundColor: ['#36A2EB', '#CCCCCC','#FF6384']
        }]
        
    }
});
    
   // crear la gráfica de tardanzas
new Chart(document.getElementById('late-chart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: ['Llegó temprano', 'Llegó tarde', 'Retirado', 'Ausente'],
        datasets: [{
            data: [data.earlyCount, data.lateCount, data.retiredCount, data.absentCount, data.absentCount - data.earlyCount - data.lateCount - data.retiredCount - data.absentCount,],
            backgroundColor: ['#36A2EB', '#42AB49', '#FF6384', '#CCCCCC']
        }]
    }
});


});
</script>
@endsection