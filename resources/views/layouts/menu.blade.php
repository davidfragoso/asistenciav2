<li class="side-menus {{ Request::is('home') ? 'active' : '' }}">
    <a class="nav-link" href="/home">
        <i class=" fas fa-chart-line"></i><span>Dashboard</span>
    </a>
</li>


<li class="dropdown">
    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">

        <i class=" fas fa-user-lock"></i><span>Acceso</span>
    </a>

    <div class="dropdown-menu dropdown-menu-right">

        <a class="dropdown-item has-icon {{ Request::is('usuarios') ? 'active' : '' }}" href="/usuarios">
            <i class="fa fa-user"></i>Usuarios</a>
        <a class="dropdown-item has-icon {{ Request::is('roles') ? 'active' : '' }}" href="/roles">
            <i class="fa fa-user"></i>Roles</a>
    </div>
</li>

<li class="dropdown">
    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">

        <i class=" fas fa-user-clock"></i><span> Asistencias</span>
    </a>

    <div class="dropdown-menu dropdown-menu-right">

        <a class="dropdown-item has-icon {{ Request::is('welcome') ? 'active' : '' }}" href="/attendances">
            <i class="fa fa-user-clock"></i>Asistencia</a>
        <a class="dropdown-item has-icon" href="/">
            <i class="fa fa-user-clock"></i>Marcar asistencia</a>
        <a class="dropdown-item has-icon" href="#">
            <i class="fa fa-user"></i>Reportes</a>

    </div>
</li>


<li class="side-menus  {{ Request::is('blogs') ? 'active' : '' }}">
    <a class="nav-link" href="/departments">
        <i class=" fas fa-users"></i><span> Departamentos</span>
    </a>
</li>

<li class="side-menus  {{ Request::is('schedules') ? 'active' : '' }}">
    <a class="nav-link" href="/schedules">
        <i class=" fas fa-calendar"></i><span> Horarios</span>
    </a>
</li>



<li class="dropdown">
    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">

        <i class=" fas fa-user-clock"></i><span> Mis Asistencias</span>
    </a>

    <div class="dropdown-menu dropdown-menu-right">

        <a class="dropdown-item has-icon" href="#">
            <i class="fa fa-user-clock"></i>Asistencia</a>
        <a class="dropdown-item has-icon" href="#">
            <i class="fa fa-user"></i>Reportes</a>

    </div>
</li>