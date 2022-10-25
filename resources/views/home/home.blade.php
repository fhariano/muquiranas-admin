@extends('adminlte::page')

@section('content')
<div class="card card-default">

    <div class="card-header">
        <h1 style="text-align:center;">Muquiranas Bar</h1>
    </div>
    <div class="container-fluid">
    @can('gerenciar_bar',$group)  
    @if($statusBar == 0)
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3" id="divAbrirBar">
                <div class="info-box mb-3">

                    <a href="javascript:void(0)" class="btn btn-sm btn-primary" role="button" id="abrirBar" title="Abrir Bar" aria-label="Abrir Bar">
                        <span class="info-box-icon sm-primary elevation-1"> <i class="fas fa-lock-open"></i> </span>
                        OPEN BAR
                    </a>
                </div>
            </div>
        </div>
    @endif
    @if($statusBar == 1)
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3" id="divFecharBar">
                <div class="info-box mb-3">
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger" role="button" id="fecharBar" title="Fechar Bar" aria-label="Fechar Bar">
                        <span class="info-box-icon sm-danger elevation-1"> <i class="fas fa-lock"></i> </span>
                        FECHAR BAR
                    </a>
                </div>
            </div>
        </div>
    @endif
    @endCan
    </div>

    <div class="card-body">
        <div class="row">


        </div>
    </div>
</div>
@endsection

@section('footer')
<div class="footer">
    Copyright © Muquiranas Bar - <?php echo date('Y'); ?>
</div>
@endsection



@section('js')

<script>
    $(function() {

        urlBase = window.location.origin;
        var urlController = '/updateStatusBar';
      
        $("#abrirBar").click(function() {
            statusBar = 1;

            
            updateStatusBar(statusBar).then((result) => {

                window.location.reload();
            
            });

               
        });

        $('#fecharBar').click(function() {
            statusBar = 0;
         

            updateStatusBar(statusBar).then((result) => {

                console.log('resultado é ' + result);
                location.reload();                       

            });
      
        });

        // function showButtonOpenCloseBar(status) {
        //     if (status == 0) {
        //         $("#divAbrirBar").attr("hidden", true);
        //         $('#divFecharBar').attr("hidden", false);

        //     } else {
        //         $('#divFecharBar').attr("hidden", true);
        //         $("#divAbrirBar").attr("hidden", false);

        //     }
        // }

        updateStatusBar = (fieldStatus) => {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: urlBase + urlController,
                    method: 'POST',
                    data: {
                        'status': fieldStatus,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(success) {
                        console.log(success)
                        return resolve(success)
                    },
                    erro: function(data) {

                        if (data.status === 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Sem conexão com internet!',
                                html: '<br>Contate o administrador.',
                            });
                            return reject(data)
                        } else if (data.status == 404 || data.status == 405) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Página Solicitada não encontrada',
                                html: '<br>Contate o administrador.',
                            });
                            return reject(data)

                        } else if (data.status == 500) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro!',
                                html: '<br>Contate o administrador.',
                            });
                            return reject(data)

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro!',
                                html: 'Erro Crítico! <br>Contate o administrador.',
                            });
                            return reject(data)
                        }


                    }

                });

            });
        }

    });
</script>


@endsection