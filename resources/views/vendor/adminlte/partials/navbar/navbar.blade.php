<?php
use Illuminate\Support\Facades\Auth;
use App\Models\Bars;

$idBar = Auth::user()->bar_id;
// $result = getStatusBar($idBar);
// $statusBar = $result['status'];
$statusBar = 1;
// $name = $result['name'];
$name ='Muquiranas Bar';


function getStatusBar($id)
{
    $result[] = '';
    try {
       $bar = Bars::find($id);
       $result['status'] = $bar->status;
       $result['name']= $bar->name;
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
       
        @if($statusBar == 1)
            @each('adminlte::partials.navbar.menu-item-statusBar-aberto', $adminlte->menu('navbar-right'), 'item')
        @else
            @each('adminlte::partials.navbar.menu-item-statusBar-fechado', $adminlte->menu('navbar-right'), 'item')
        @endif

       

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


  <ul class="navbar-nav" style="text-align:center;"> 
        <h1 style="text-align:center;"> <? echo $name;?></h1> 
  </ul>
    
    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')
        
        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')
        
        
        
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

