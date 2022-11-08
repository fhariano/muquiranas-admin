@extends('adminlte::page')

@section('content')
<div class="card card-default">

    <div class="card-header">
        <h1 style="text-align:center;">Muquiranas Bar</h1>
    </div>
    <div class="container-fluid">
        @can('gerenciar_bar',$group)

        <input hidden type="text" id="statusBar" class="form-control" value="<?=$statusBar;?>">

        <div class="row">
            <div class="col-12 col-sm-6 col-md-3" id="divAbrirBar">
                <div class="info-box mb-3">

                    <button href="javascript:void(0)" class="btn btn-sm btn-success" role="button" id="abrirBar" title="Abrir Bar" aria-label="Abrir Bar">
                        <span class="info-box-icon sm-primary elevation-1"> <i class="fas fa-lock-open"></i> </span>
                        ABRI BAR
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-6 col-md-3" id="divFecharBar">
                <div class="info-box mb-3">
                    <button href="javascript:void(0)" class="btn btn-sm btn-danger" role="button" id="fecharBar" title="Fechar Bar" aria-label="Fechar Bar">
                        <span class="info-box-icon sm-danger elevation-1"> <i class="fas fa-lock"></i> </span>
                        FECHAR BAR
                    </button>
                </div>
            </div>
        </div>

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
        const statusBar = document.getElementById('statusBar').value;

        if(statusBar == 1){
            document.getElementById("abrirBar").disabled = true;
        }else{
            document.getElementById("fecharBar").disabled = true;
        }

        //desabilita o botão no início

        $("#abrirBar").click(function() {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Abrir bar?',
                html: 'Deseja realmente abrir esse bar?',
                allowOutsideClick: false,
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: '<i class="fa fa-thumbs-up pr-1 pl-1"></i> SIM ',
                cancelButtonText: '<i class="fa fa-thumbs-down pr-1 pl-1"></i> CANCELAR',
            }).then((result) => {
                if (result.isConfirmed) {

                    document.getElementById("abrirBar").disabled = true;
                    document.getElementById("fecharBar").disabled = false;

                    statusBarAtualizado = 1;
                    updateStatusBar(statusBarAtualizado).then((result) => {
                        location.reload();   
                        Swal.fire({
                            icon: 'success',
                            title: 'BAR ABERTO!',
                            html: 'O bar foi aberto com sucesso!',
                        });
                    });

                }
            });


        });

        $('#fecharBar').click(function() {

            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Fechar bar?',
                html: 'Deseja realmente fechar esse bar?',
                allowOutsideClick: false,
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: '<i class="fa fa-thumbs-up pr-1 pl-1"></i> SIM ',
                cancelButtonText: '<i class="fa fa-thumbs-down pr-1 pl-1"></i> CANCELAR',
            }).then((result) => {
                if (result.isConfirmed) {

                    document.getElementById("fecharBar").disabled = true;
                    document.getElementById("abrirBar").disabled = false;

                    statusBarAtualizado = 0;
                    location.reload();   
                    updateStatusBar(statusBarAtualizado).then((result) => {
                        Swal.fire({
                            icon: 'success',
                            title: 'BAR FECHADO!',
                            html: 'O bar foi fechado com sucesso!',
                        });

                    });

                }
            });





        });

    
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