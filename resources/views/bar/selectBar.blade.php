
@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])


<div class="jumbotron">
    

    <div class="list-group">
    @foreach($fieldsBarsUser as $key => $value)
        @if(isset($value->bar_id))
            <a href= "  javascript:void(0)" id="selecBar"  class="list-group-item list-group-item-action list-group-item-primary" onclick="requestBarSelecionado('{{$value->bar_id}}');">  {{$value->nameBar}} </a>
        @else
        <a href= "javascript:void(0)" class="list-group-item list-group-item-action list-group-item-primary">  SEM BAR CADASTRADO </a>
        @endif

    @endforeach

    </div>

    <div class="bd-example sr-only">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
    </div>

</div>


@section('js')
<script>

$(function() {
    var urlBase = window.location.origin;
    var urlController = '/bar/';
    requestBarSelecionado = (val) => {
   
        $.ajax({
            url: urlBase + urlController + 'requestSelectBar',
            method: 'POST',
            data: {
                'idBarSelecionado' : val,
            },
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {

                
                $('.bd-example').removeClass('sr-only');
                $('.list-group').addClass('sr-only');
        
                window.location.replace(response);

            },
        })
    }

})

</script>

@endsection