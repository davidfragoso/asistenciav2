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

                                    @if (Route::has('register'))
                                    <a href="{{ route('register') }}">Registrarse</a>
                                    @endif
                                    @endauth
                                </div>
                                @endif
                            </div>

                            <div class="card-body">
                                <div class="flex-center position-ref full-height">


                                    <div class="content">
                                        <div class="title m-b-md">
                                            <div class="clockStyle" id="clock">123</div>
                                        </div>
                                    </div>

                                </div>


                            </div>
                            
                            <div class="card-footer text-center">
                                <div class="links">
                                    <form action="{{ route('attendance.mark') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <button type="submit">Entrada</button>
                                    </form>
                                    <span><strong> | </strong></span>
                                    <form action="{{ route('attendance.departure') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="attendance_id" value="{{ $attendance->attendance_id }}">
                                        <button type="submit">Salida</button>
                                    </form>
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