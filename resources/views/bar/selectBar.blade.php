
@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])


<div class="jumbotron">
    

    <div class="list-group">
    @foreach($fieldsBarsUser as $key => $value)
    <a href="{{$value->bar_id}}" class="list-group-item list-group-item-action list-group-item-primary"> {{$value->nameBar}} </a>
    @endforeach

    </div>

</div>

