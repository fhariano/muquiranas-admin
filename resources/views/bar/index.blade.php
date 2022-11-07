@extends('adminlte::page')

@section('content')

<div class="card card-default">
    <div class="card-header">
        <h1 align="center"> <b> Informações do Bar </b></h1>
    </div>

    <div class="card-body">

        <div class="modal fade" id="modal_bar" tabindex="-1" role="dialog" aria-labelledby="modalbar_Label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalbar_label"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="tbl_modalbar" name="tbl_modalbar" method="POST" enctype="multipart/form-data" onsubmit="return check(event)" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group col-12 d-flex justify-content-between">
                                <div class="col-4">
                                    <label for="recipient-name" class="col-form-label">Name</label>
                                    <input type="text" name="name_bar" id="name_bar" class="form-control">
                                    <div id="nametFeedback" class="invalid-feedback">
                                        Preencha o nome!
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="recipient-shortName" class="col-form-label">Name Curto</label>
                                    <input type="text" name="short_name" id="short_name" class="form-control">
                                    <div id="shortNameFeedback" class="invalid-feedback">
                                        Preencha o nome curto!
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="recipient-address" class="col-form-label">Endereço</label>
                                    <input type="text" name="address_bar" id="address_bar" class="form-control">
                                    <div id="addressFeedback" class="invalid-feedback">
                                        Preencha o endereço.
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="button" id="button_insert_bar" class="btn btn-success"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="barToolbar">
            </div>

            <div id="adminBar" class="col-12 table-responsive pt-1">
                <table id="tbl_adminBar" class="table table table-bordered table-hover"> </table>
            </div>
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

       var $tbl_adminBar = $('#tbl_adminBar');
       var urlBase = window.location.origin;
       var urlController = '/bar/';

        $tbl_adminBar.bootstrapTable({

            url: urlBase + urlController + 'show/',
            pagination: true,
            toolbar: '#barToolbar',
            search: true,
            columns: [{

                    field: 'id',
                    title: 'ID',
                    visible: false
                },
                {
                    field: 'name',
                    title: 'Name'
                },
                {
                    field: 'short_name',
                    title: 'Nome curto'
                },
                {
                    field: 'address',
                    title: 'Endereço'
                },
            ],
            onLoadSuccess: function(data) {
                html = '@can("gerenciar_bar",$group_id)';
                html += '';
                html += '<div class="bs-bars float-left"> <button type="button" id="create_bar" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal_bar" onclick="clickOpenModalBar(1);" ><i class="fas fa-plus pr-2"></i> Bar </button> <br> </br>'
                html += '@endcan'
                $('#barToolbar').html(html);
            }
        });

        clickOpenModalBar = (val) => {
            if (val == 1) {
                clearFieldsModalBar()
            }
        }

        function clearFieldsModalBar() {
            $('#tbl_modalbar input').val("");
            $('input').removeClass(["is-valid", "is-invalid"]);
            $('#button_insert_bar').text('Cadastrar');
            $('#button_insert_bar').removeAttr('name', 'Salvar');
            $("#button_insert_bar").attr('name', 'InsertBar');
            $('#modalbar_label').html('<b>Criar Bar</b>');
            $('#modal_bar').modal('show');
        }

        function formValidator(nameBar, shortName, addressBar) {

            var validatedFields = false;

            if (nameBar.value == '') {
                nameBar.classList.add("is-invalid");
                return validatedFields = false;

            } else {
                nameBar.classList.remove("is-invalid");
                nameBar.classList.add("is-valid");
                // validatedFields = true;
            }

            if (shortName.value == '') {
                shortName.classList.add("is-invalid");
                return validatedFields = false;

            } else {
                shortName.classList.remove("is-invalid");
                shortName.classList.add("is-valid");
                // validatedFields = true;
            }
            if (addressBar.value == '') {
                addressBar.classList.add("is-invalid");
                return validatedFields = false;

            } else {
                addressBar.classList.remove("is-invalid");
                addressBar.classList.add("is-valid");
                // validatedFields = true;
            }


            let fields = {
                name: nameBar.value,
                short_name: shortName.value,
                address: addressBar.value,
            }

            return fields;
        }


        $('#button_insert_bar').click(function(e) {
            event.preventDefault();
            event.stopPropagation();

            var name_bar = document.getElementById('name_bar');
            var short_name = document.getElementById('short_name');
            var address_bar = document.getElementById('address_bar');

            var actionButtonSaveBar = event.target.name;
            var resultValidation = formValidator(name_bar, short_name, address_bar);

            if(actionButtonSaveBar == 'InsertBar' && resultValidation != false){
                saveBar(resultValidation);
            }else {
                console.log('Fazer update');
            }
        
        });


        function saveBar(fields) {
            $.ajax({
                url: urlBase + urlController + 'store', 
                method: 'POST',
                data: {
                    'data': JSON.stringify(fields),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(success) {
               
                    console.log('retorno:  ' + success);

                    $tbl_adminBar.bootstrapTable('refresh');
                        Swal.fire({
                            icon: 'success',
                            title: 'Salvo!',
                            html: 'Novo bar cadastrado com sucesso!',
                        });

                        $('#modal_bar').modal('hide');                  

                },
                error: function(data) {
                    if (data.status === 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Sem conexão com internet!',
                            html: '<br>Contate o administrador.',
                        });
                    } else if (data.status == 404 || data.status == 405) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Página Solicitada não encontrada',
                            html: '<br>Contate o administrador.',
                        });

                    } else if (data.status == 500) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            html: '<br>Contate o administrador.',
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            html: 'Erro Crítico! <br>Contate o administrador.',
                        });

                    }
            
                }

            })
        }



    });
</script>
@endsection