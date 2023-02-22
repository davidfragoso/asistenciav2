<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <img class="navbar-brand-full app-header-logo" src="{{ asset('img/ae_fondo_claro.png') }}" width="65"
             alt="Infyom Logo"> AttendEase
        <a href="{{ url('/home') }}"></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ url('/home') }}" class="small-sidebar-text">
            <img class="navbar-brand-full" src="{{ asset('img/ae_fondo_claro.png') }}" width="50px" height="50px" alt=""/>
        </a>
    </div>
    <ul class="sidebar-menu">
        @include('layouts.menu')
    </ul>
</aside>
