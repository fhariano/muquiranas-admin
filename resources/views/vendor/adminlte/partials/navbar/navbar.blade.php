<?php
use Illuminate\Support\Facades\Auth;
use App\Models\Bars;

$idBar = Auth::user()->bar_id;
$statusBar = getStatusBar($idBar);

function getStatusBar($id)
{
    try {
        $bar = Bars::find($id);
        $result = $bar->status;
    } catch (\Throwable $th) {
        return $th;
    }

    return $result;
}

?>


<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')
        
        @if($statusBar == 1)
            @each('adminlte::partials.navbar.menu-item-statusBar-aberto', $adminlte->menu('navbar-right'), 'item')
        @else
        @each('adminlte::partials.navbar.menu-item-statusBar-fechado', $adminlte->menu('navbar-right'), 'item')

        @endif
        {{-- User menu link --}}
        @if(Auth::user())
            @if(config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif
        

        {{-- Right sidebar toggler link --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
        
    </ul>

</nav>

