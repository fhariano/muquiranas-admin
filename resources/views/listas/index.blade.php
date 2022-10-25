@extends('adminlte::page')

@section('content')
<div class="card card-default">
    <div class="card-header">
        <h1 align="center"> <b>Listas de Promoções </b></h1>
    </div>

    <div class="card-body">

        <div class="modal fade" id="modal_list" tabindex="-1" role="dialog" aria-labelledby="modalList_Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalList_label"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="tbl_modalList">
                            @csrf
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Name</label>
                                <input type="text" id="name_list" class="form-control">
                                <div id="nametFeedback" class="invalid-feedback">
                                    Preencha o nome!
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="button" id="button_insert_list" class="btn btn-success"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="listsToolbar">
            </div>

            <div id="listsPromo" class="col-12 table-responsive pt-1">
                <table id="tbl_listas" class="table table table-bordered table-hover"> </table>
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

        $tbl_listas = $('#tbl_listas');
        urlBase = window.location.origin;
        urlController = '/listas/';
        var idPromoList = '';
        const bar_id = 1;
        var fieldActive = '';


        window.categoriesActionFormatter = function(index, row, $detail) {
            var html= '@can("gerenciar_listas",$group_id)';
            html += '<div>';
            html += '<a href="javascript:void(0)" class="editCategory" id="editList" title="Editar Lista"><i class=" fas fa-pencil-alt fa-lg pr-2"></i></a>';
            html += '<a href="javascript:void(0)" class="delCategory" id="delCategory" title="Apagar Lista"><i class=" fas fa-times fa-lg text-danger pl-2"></i></a>';
            html += '</div>';
            html += '@endcan';
            return html;

        }

        disableListPromo = (id, active) => {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: urlBase + urlController + 'disableListPromo',
                    method: 'PUT',
                    data: {
                        'data': active,
                        'id': id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                }).then(result => {
                    resolve(result);
                })

            });
        }


        window.categoryStatusEvents = {


            'click .custom-control-input': function(e, value, row, index) {
                e.preventDefault();
                e.stopPropagation();
                // location.reload();
                if (row.active == 1) {

                    fieldActive = 0;
                    disableListPromo(row.id, fieldActive).then((res) => {

                        console.log(`Resolve em result: ${res}`);
                        $('#tbl_listas').bootstrapTable('refresh');
                        if (res == true) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Desativada',
                                html: 'Lista desativada com sucesso!',
                            });

                        }

                    }).catch(err => {
                        console.log('erro' + err);
                    });

                } else {
                    fieldActive = 1;
                    disableListPromo(row.id, fieldActive).then((res) => {
                        $('#tbl_listas').bootstrapTable('refresh');

                        console.log(`Resolve em result: ${res}`);
                        if (res == true) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Ativada',
                                html: 'Lista ativada com sucesso!',
                            });

                        }

                    }).catch(err => {
                        console.log('erro' + err);
                    });
                }

            }
        }

        clickOpenModalListPromo = (val) => {
            if (val == 1) {
                clearFieldsModalList();
            }
        }

        function clearFieldsModalList() {
            $('#name_list').val('');
            $('input').removeClass(["is-valid", "is-invalid"]);
            $('#button_insert_list').text('Cadastrar');
            $('#button_insert_list').removeAttr('name', 'Salvar');
            $("#button_insert_list").attr('name', 'Cadastrar');
            $('#modalList_label').html('<b>Criar Lista de Promoção</b>');
            $('#modal_list').modal('show');
        }

        window.listPromoEditEvents = {

            'click #editList': function(e, value, row, index) {

                idPromoList = row.id;
                fieldActive = row.active;
                $('#name_list').val(row.name);
                $('#modalList_label').html('<b>Editar Lista de promoção</b>');
                $('#button_insert_list').text('Salvar');
                // $('#orderCategory').val(row.order);
                // $('#price').val(row.price);
                // $('#promoProduct').attr('disabled', 'disabled');
                // $("#promoProduct").val(row.product_id).change().prop('selected', true);
                // $('#buttonSavePreco').text('Salvar Preço')
                $('#button_insert_list').removeAttr('name', 'Cadastrar');
                $("#button_insert_list").attr('name', 'Salvar');
                $("input").removeClass(["is-valid", "is-invalid"])
                // $("select").removeClass(["is-invalid"])
                $('#modal_list').modal('show');


            }
        }

        window.listaActionFormatter = function(index, row, $detail) {
            var html = '<div>';
            if (row.active == 1) {
                var html = '@can("gerenciar_listas", $group_id)'
                html += '<div class="custom-control custom-switch">';
                html += '<input type="checkbox" class="custom-control-input" id="customSwitchList' + row.id + '" checked >';
                html += '<label class="custom-control-label" for="customSwitchList' + row.id + '"></label>';
                html += '</div>';
                html += '@endcan';

                return html;
            } else {
                var html = '@can("gerenciar_listas", $group_id)'
                html += '<div class="custom-control custom-switch">';
                html += '<input type="checkbox" class="custom-control-input" id="customSwitchList' + row.id + '">';
                html += '<label class="custom-control-label" for="customSwitchList' + row.id + '"></label>';
                html += '</div>';
                html += '@endcan';
                return html;
            }

        }

        function formValidator(fieldName) {
            var validatedFields = false;

            if (fieldName.value == '') {
                fieldName.classList.add("is-invalid");
                return validatedFields = false;
            } else {
                fieldName.classList.remove("is-invalid");
                fieldName.classList.add("is-valid");
            }

            const fields = {
                name: fieldName.value,
            }

            return fields;

        }



        /* Criação Tabela Categoria*/
        $tbl_listas.bootstrapTable({

            url: urlBase + urlController + 'show/',
            pagination: true,
            // clickToSelect: true,
            toolbar: '#listsToolbar',

            search: true,
            columns: [{
                    field: 'active',
                    title: 'Ativo',
                    sortable: false,
                    visible: true,
                    halign: 'center',
                    align: 'center',
                    width: '100',
                    widthUnit: 'px',
                    formatter: 'listaActionFormatter',
                    events: 'categoryStatusEvents',

                },
                {
                    field: 'id',
                    title: 'ID',
                    visible:false
                },
                {
                    field: 'name',
                    title: 'Name'
                },
                {
                    title: 'Ações',
                    sortable: false,
                    visible: true,
                    halign: 'center',
                    align: 'center',
                    width: '100',
                    widthUnit: 'px',
                    formatter: 'categoriesActionFormatter',
                    events: 'listPromoEditEvents',
                }
            ],
            onLoadSuccess: function(data) {
                html = '@can("gerenciar_listas",$group_id)';
                html += '';
                html += '<div class="bs-bars float-left"> <button type="button" id="create_list" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal_list" onclick="clickOpenModalListPromo(1);"><i class="fas fa-plus pr-2"></i> Lista </button> <br> </br>'
                html +='@endcan'
                $('#listsToolbar').html(html);
            }
        })
    
        $('#button_insert_list').click(function(event) {
            event.preventDefault();
            event.stopPropagation();

            let name = document.getElementById('name_list');
            var resultValidation = formValidator(name);
            var actionButtonSaveList = event.target.name;
            
            if (actionButtonSaveList == 'Cadastrar' && resultValidation != false) {
                insertPromosList(resultValidation.name);
             
            } else {
                if (actionButtonSaveList == 'Salvar' && resultValidation != false) {
                 
                    updateListPromo(idPromoList, resultValidation.name, fieldActive).then((result) => {
                        if (result == true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Atualizado com sucesso',
                                html: 'Informações Atualizadas!',
                            });
                            $('#tbl_listas').bootstrapTable('refresh');
                            $('#modal_list').modal('hide');
                        }
                    });
                }

            }
      

        });

        function insertPromosList(data) {
            $.ajax({
                url: urlBase + urlController + 'store',
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    'name': data
                },
                success: function(success) {
                    
                    if (success == 2) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Atenção!',
                            html: 'Já uma lista cadastrada com esse nome!',
                        });
                        // $(id_modal).modal('hide');
                    } else if (success == true) {
                        $tbl_listas.bootstrapTable('refresh');
                        Swal.fire({
                            icon: 'success',
                            title: 'Salvo!',
                            html: 'Lista salva com sucesso!',
                        });
                        $('#modal_list').modal('hide');
                    }
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

                    // console.log(
                    // 'STATUS : ' + data.status + 
                    // ' TEXT STATUS : ' + data.statusText + 
                    // 'TEXT RESPONSE :' + data.responseText);
                }
            });

        }

        updateListPromo = (id, name, active) => {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: urlBase + urlController + 'update',
                    method: 'PUT',
                    data: {
                        'id': id,
                        'name': name,
                        'active': active,

                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(success) {
                        
                        return resolve(success)
                    },
                    error: function(data) {
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