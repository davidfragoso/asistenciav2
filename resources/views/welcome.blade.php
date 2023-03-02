<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') | {{ config('app.name') }}</title>

    <!-- General CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/components.css')}}">

    <link rel="stylesheet" href="{{ asset('web/css/custom.css') }}">

</head>

<body>
    <div id="app">
        <section class="section d-flex">
            <div class="container mt-5">
                <div class="row">
                    <div class="container">
                        <div class="login-brand">
                            <h3 class="page__heading">Asistencia</h3>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                @if (Route::has('login'))
                                <div class="top-right links">
                                    @auth
                                    <a href="{{ url('/home') }}">Home</a>
                                    @else
                                    <a href="{{ route('login') }}">Iniciar Sesión</a>
                                    @endauth
                                </div>
                                @endif
                            </div>
                            @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif

                            @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                            @endif

                            <div class="card-body">
                                <div class="flex-center position-ref full-height">
                                    <div class="content">
                                        <h4>Bienvenido, {{ auth()->user()->name }}</h4>
                                        <h4>Hoy es {{ \Carbon\Carbon::now()->format('d/m/Y') }}</h4>
                                        <div class="title m-b-md">
                                            <div class="clockStyle" id="clock">123</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-center">
                                <div class="links">
                                    @if(session('button_text') == 'Salida')
                                    <button class="btn btn-danger" data-toggle="modal"
                                        data-target="#markAttendanceModal">Salida</button>
                                    @else
                                    <button class="btn btn-primary" data-toggle="modal"
                                        data-target="#markAttendanceModal">Entrada</button>
                                    @endif

                                </div>

                                <div class="modal fade" id="markAttendanceModal" tabindex="-1" role="dialog"
                                    aria-labelledby="markAttendanceModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="markAttendanceModalLabel">
                                                    @if(session('button_text') == 'Salida')
                                                    Marcar salida
                                                    @else
                                                    Marcar entrada
                                                    @endif
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="markAttendanceForm" action="{{ route('attendance.mark') }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="user_id">ID de usuario:</label>
                                                        <input type="text" class="form-control" id="user_id"
                                                            name="user_id">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn
                                                    @if(session('button_text') == 'Salida')
                                                    btn-danger
                                                    @else
                                                    btn-primary
                                                    @endif
                                                    ">
                                                        @if(session('button_text') == 'Salida')
                                                        Marcar salida
                                                        @else
                                                        Marcar entrada
                                                        @endif
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>

    <script type="text/javascript">
        setInterval(displayclock, 500);

    function displayclock() {
        var time = new Date();
        var hrs = time.getHours();
        var min = time.getMinutes();
        var sec = time.getSeconds();
        var en = 'AM';
        if (hrs >= 12) {
            en = 'PM';
        }
        if (hrs > 12) {
            hrs = hrs - 12;
        }
        if (hrs == 0) {
            hrs = 12;
        }
        if (hrs < 10) {
            hrs = '0' + hrs;
        }
        if (min < 10) {
            min = '0' + min;
        }
        if (sec < 10) {
            sec = '0' + sec;
        }
        document.getElementById("clock").innerHTML = hrs + ':' + min + ':' + sec + ' ' + en;
    }
    </script>
    <!-- Template JS File -->
    <script src="{{ asset('web/js/stisla.js') }}"></script>
    <script src="{{ asset('web/js/scripts.js') }}"></script>
    <!-- Page Specific JS File -->
</body>

</html>