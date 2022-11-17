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
                                    <div id="nameFeedback" class="invalid-feedback">
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
                                    <label for="recipient-cnpj" class="col-form-label">CNPJ</label>
                                    <input type="text" name="cnpj_bar" id="cnpj_bar" class="form-control">
                                    <div id="cnpjFeedback" class="invalid-feedback">
                                        Preencha o CNPJ.
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-12 d-flex justify-content-between">

                                <div class="col-4">
                                    <label for="recipient-address" class="col-form-label">Endereço</label>
                                    <input type="text" name="address_bar" id="address_bar" class="form-control">
                                    <div id="addressFeedback" class="invalid-feedback">
                                        Preencha o endereço.
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="recipient-complement" class="col-form-label">Bairro</label>
                                    <input type="text" name="complement_address" id="complement_address" class="form-control">

                                </div>
                                <div class="col-1">
                                    <label for="recipient-number" class="col-form-label">Nº</label>
                                    <input type="text" name="number_address" id="number_address" class="form-control">
                                    <div id="numberAddressFeedback" class="invalid-feedback">
                                        Preencha o número!
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label for="recipient-cep" class="col-form-label">CEP</label>
                                    <input type="text" name="cep_bar" id="cep_bar" class="form-control">
                                    <div id="cepFeedback" class="invalid-feedback">
                                        Preencha o cep!
                                    </div>
                                </div>

                            </div>


                            <div class="form-group col-12 d-flex justify-content-between">
                                 <div class="col-3">
                                    <label for="recipient-city_state" class="col-form-label">Cidadade/Estado</label>
                                    <input type="text" name="city_state" id="city_state" class="form-control">
                                </div>
                                <div class="col-2">
                                    <label for="recipient-start_at" class="col-form-label">Abertura</label>
                                    <input type="time" name="start_at" id="start_at" class="form-control">
                                    <div id="startAtFeedback" class="invalid-feedback">
                                        Preencha a hora de abertura.
                                    </div>
                                </div>
                                <div class="col-2">
                                    <label for="recipient-end_at" class="col-form-label">Fechamento</label>
                                    <input type="time" name="end_at" id="end_at" class="form-control">
                                    <div id="endAtFeedback" class="invalid-feedback">
                                        Preencha o  hora de fechamento.
                                    </div>
                                </div>

                                <div class="col-2">
                                    <label for="recipient-order" class="col-form-label">Order</label>
                                    <input type="number" name="order_bar" id="order_bar" class="form-control">
                                    <div id="orderBarFeedback" class="invalid-feedback">
                                        Preencha o ordem!
                                    </div>
                                </div>

                                <div class="col-3">
                                    <label for="recipient-tokenBar_erp" class="col-form-label">Token Autenticação</label>
                                    <input type="text" name="tokenBar_erp" id="tokenBar_erp" class="form-control">
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
        var idBar = '';

        $("#cep_bar").mask("99.999-999");
        $('#cnpj_bar').mask('000.000.000-00', {
            onKeyPress: function(cnpj_bar, e, field, options) {
                const masks = ['000.000.000-000', '00.000.000/0000-00'];
                const mask = (cnpj_bar.length > 14) ? masks[1] : masks[0];
                $('#cnpj_bar').mask(mask, options);
            }
        });


        window.barEvents = {

            'click #editBar': function(e, value, row, index) {
                idBar = row.id;
                $('#name_bar').val(row.name);
                $('#short_name').val(row.short_name);
                $('#address_bar').val(row.address);
                // $('#promoProduct').attr('disabled', 'disabled');
                $('#button_insert_bar').text('Salvar Bar')
                $('#button_insert_bar').removeAttr('name', 'InsertPrice');
                $("#button_insert_bar").attr('name', 'UpdateBar');
                $("input").removeClass(["is-valid", "is-invalid"]);
                $('#modalbar_label').html('<b>Editar Bar</b>');
                $('#modal_bar').modal('show');

            },
            'click #delBar': function(e, value, row, index) {
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Apagar Bar?',
                    html: 'ATENÇÃO: Esse bar será excluído!',
                    allowOutsideClick: false,
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText: '<i class="fa fa-thumbs-up pr-1 pl-1"></i> SIM ',
                    cancelButtonText: '<i class="fa fa-thumbs-down pr-1 pl-1"></i> CANCELAR',
                }).then((result) => {
                    if (result.isConfirmed) {
                        disableProuctCardapio(row.id);
                    }
                });
            },



        }

        window.formaterImgBar = function(index, row, $detail) {
            var html = '<div>';
            html += '<img style="height:50px" src="' + row.image_url + '">';
            html += '</div>';
            return html;

        }


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
                    field: 'image_url',
                    title: 'Imagem',
                    sortable: false,
                    visible: true,
                    halign: 'center',
                    align: 'center',
                    width: '1',
                    widthUnit: '%',
                    formatter: 'formaterImgBar'
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
                {
                    field: 'actions',
                    title: 'Ações',
                    sortable: false,
                    visible: true,
                    halign: 'center',
                    align: 'center',
                    width: '100',
                    widthUnit: 'px',
                    formatter: 'actionsBarFormatter',
                    events: 'barEvents',
                }
            ],
            onLoadSuccess: function(data) {
                html = '@can("gerenciar_bar",$group_id)';
                html += '';
                html += '<div class="bs-bars float-left"> <button type="button" id="create_bar" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal_bar" onclick="clickOpenModalBar(1);" ><i class="fas fa-plus pr-2"></i> Bar </button> <br> </br>'
                html += '@endcan'
                $('#barToolbar').html(html);
            }
        });

        window.actionsBarFormatter = function(index, row, $detail) {
            var html = '@can("editar_bar",$group_id)';
            html += '<div>';
            html += '<a href="javascript:void(0)" class="editBar" id="editBar" title="Editar Bar" onclick="clickOpenModalBar(0);"><i class=" fas fa-pencil-alt fa-lg pr-2"></i></a>';
            html += '<a href="javascript:void(0)" class="delBar" id="delBar" title="Apagar Bar"><i class=" fas fa-times fa-lg text-danger pl-2"></i></a>';
            html += '</div>';
            html += '@endcan';

            return html;

        }

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




        function formValidator(name_bar, short_name, cnpj_bar, address_bar,complement_address,number_address,cep_bar,city_state,start_at,end_at,order_bar,tokenBar_erp) {

            var validatedFields = false;

            if (name_bar.value == '') {
                name_bar.classList.add("is-invalid");
                return validatedFields = false;

            } else {
                name_bar.classList.remove("is-invalid");
                name_bar.classList.add("is-valid");
                // validatedFields = true;
            }

            if (short_name.value == '') {
                short_name.classList.add("is-invalid");
                return validatedFields = false;

            } else {
                short_name.classList.remove("is-invalid");
                short_name.classList.add("is-valid");

            }    
                // validatedFields = true;
           
            if (cnpj_bar.value == '') {
                cnpj_bar.classList.add("is-invalid");
                return validatedFields = false;

            } else {
                cnpj_bar.classList.remove("is-invalid");
                cnpj_bar.classList.add("is-valid");
                var cnpj_validator = cnpj_bar.value.replace(/\.|\-/g, '').replace('/','');
         
            }
            if (address_bar.value == '') {
                address_bar.classList.add("is-invalid");
                return validatedFields = false;

            } else {
                address_bar.classList.remove("is-invalid");
                address_bar.classList.add("is-valid");
                // validatedFields = true;
            }
            if (complement_address.value == '') {
                complement_address.classList.add("is-invalid");
                return validatedFields = false;

            } else {
                complement_address.classList.remove("is-invalid");
                complement_address.classList.add("is-valid");
                // validatedFields = true;
            }


            let fields = {
                name: name_bar.value,
                short_name: short_name.value,
                cnpj:cnpj_validator,
                address: address_bar.value,
                
                
            }

            return fields;
        }


        $('#button_insert_bar').click(function(e) {
            event.preventDefault();
            event.stopPropagation();

            var name_bar = document.getElementById('name_bar');
            var short_name = document.getElementById('short_name');
            var cnpj_bar = document.getElementById('cnpj_bar');
            var address_bar = document.getElementById('address_bar');
            var complement_address = document.getElementById('complement_address');
            var number_address = document.getElementById('number_address');
            var cep_bar = document.getElementById('cep_bar');
            var city_state = document.getElementById('city_state');
            var start_at = document.getElementById('start_at');
            var end_at = document.getElementById('end_at');
            var order_bar = document.getElementById('order_bar');
            var tokenBar_erp = document.getElementById('tokenBar_erp');

            var actionButtonSaveBar = event.target.name;
            var resultValidation = formValidator(name_bar, short_name, cnpj_bar, address_bar,complement_address,number_address,cep_bar,city_state,start_at,end_at,order_bar,tokenBar_erp);

            if (actionButtonSaveBar == 'InsertBar' && resultValidation != false) {
                // saveBar(resultValidation);

                console.log( JSON.stringify(resultValidation));
            } else {
                if (actionButtonSaveBar == 'UpdateBar' && resultValidation != false) {

                    updateBar(resultValidation, idBar);
                }

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

        function updateBar(fields, id) {
            $.ajax({
                url: urlBase + urlController + 'update',
                method: 'PUT',
                data: {
                    'data': JSON.stringify(fields),
                    'id': JSON.stringify(id)
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(success) {

                    console.log("Result Sucesso:" + success);
                    $tbl_adminBar.bootstrapTable('refresh');
                    Swal.fire({
                        icon: 'success',
                        title: 'Atualizado com Sucesso!',
                        html: 'Informações Atualizadas!',
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

        function disableProuctCardapio(id) {

            $.ajax({
                url: urlBase + urlController + 'destroy',
                method: 'PUT',
                data: {
                    'id': JSON.stringify(id)
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },
                success: function(success) {
                    console.log("Result Sucesso:" + success);
                    $tbl_adminBar.bootstrapTable('refresh');
                    Swal.fire({
                        icon: 'success',
                        title: 'OK',
                        html: 'Bar Excluido com sucesso!',
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