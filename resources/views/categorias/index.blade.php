@extends('adminlte::page')


@section('content')
<div class="card card-default">

    <div class="card-header">
        <h1 style=text-align:center> <b> Categorias </b> </h1>
    </div>
    <div class="card-body">
        <!-- <a href="{{ route('categorias.create') }}" class="btn btn-success mb-4"> Cadastrar Categoria </a> -->

        <div class="modal fade" id="modalCategory" tabindex="-1" role="dialog" aria-labelledby="modalCategory_Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCategory_label">Editar Categoria</h5>

                    </div>

                    <div class="modal-body">

                        <form id="tbl_modalCategory" class="needs-validation" novalidate>

                            @csrf


                            <div class="form-group col-8 d-flex justify-content-between">
                                <div class="col-8">
                                    <label for="name" class="col-form-label">Nome</label>
                                    <input type="text" id="nameCategory" class="form-control" value="" required>
                                    <div id="nametFeedback" class="invalid-feedback">
                                        Preencha o nome!
                                    </div>
                                </div>

                                <div class="col-8">
                                    <label for="order" class="col-form-label">Ordem</label>
                                    <input type="number" id="orderCategory" class="form-control" required>
                                    <div id="orderFeedback" class="invalid-feedback">
                                        Preencha a order.
                                    </div>
                                </div>


                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="button" id="buttonSaveCategory" class="btn btn-success">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="cls_tbl_categories" class="col-12 table-responsive pt-1">
                <table id="tbl_categories" class="table table table-bordered table-hover"></table>

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

        var tbl_categories = $('#tbl_categories');
        // url = "categorias/show";
        var idCategory = '';
        urlBase = window.location.origin;
        var urlController = '/categorias/';
        var fieldActive = '';
        /* Criação Tabela Categoria*/


        window.categoriesActionFormatter = function(index, row, $detail) {
            var html='@can("gerenciar_cardapio", $group_id)';
            html += '<div>';
            html += '<a href="javascript:void(0)" class="editCategory" id="editCategory" title="Editar Categoria"><i class=" fas fa-pencil-alt fa-lg pr-2"></i></a>';
            html += '</div>';
            html += '@endcan';

            return html;

        }

        window.categoriesStatusFormatter = function(index, row, $detail) {
            if (row.active == 1) {
                var html='@can("gerenciar_cardapio", $group_id)';
                html += '<div class="custom-control custom-switch">';
                html += '<input type="checkbox" class="custom-control-input" id="customSwitch' + row.id + '" checked >';
                html += '<label class="custom-control-label" for="customSwitch' + row.id + '"></label>';
                html += '</div>';
                html += '@endcan';

                return html;
            } else {
                var  html='@can("gerenciar_cardapio", $group_id)';
                html += '<div class="custom-control custom-switch">';
                html += '<input type="checkbox" class="custom-control-input" id="customSwitch' + row.id + '">';
                html += '<label class="custom-control-label" for="customSwitch' + row.id + '"></label>';
                html += '</div>';
                html += '@endcan';
                return html;
            }


        }


        window.categoryStatusEvents = {


            'click .custom-control-input': function(e, value, row, index) {
                e.preventDefault();
                e.stopPropagation();

                if (row.active == 1) {

                    fieldActive = 0;
                    disableCategory(row.id, fieldActive).then((result) => {

                        if (result == true) {

                            $('#tbl_categories').bootstrapTable('refresh');
                            Swal.fire({
                                icon: 'success',
                                title: 'Desativada',
                                html: 'Categoria desativada com sucesso!',
                            });


                        }

                    })
                } else {

                    fieldActive = 1;
                    disableCategory(row.id, fieldActive).then((result) => {
                        if (result == true) {
                            $('#tbl_categories').bootstrapTable('refresh');
                            Swal.fire({
                                icon: 'success',
                                title: 'Ativada',
                                html: 'Categoria ativada com sucesso!',
                            });


                        }

                    })


                }


            }
        }



        window.categoryEditEvents = {

            'click #editCategory': function(e, value, row, index) {

                idCategory = row.id;
                $('#nameCategory').val(row.name);
                $('#orderCategory').val(row.order);
                $("input").removeClass(["is-valid", "is-invalid"])
                $('#modalCategory').modal('show');
            }
        }

        function formValidator(fieldName, order) {
            var validatedFields = false;

            if (fieldName.value == '') {
                fieldName.classList.add("is-invalid");
                return validatedFields = false;
            } else {
                fieldName.classList.remove("is-invalid");
                fieldName.classList.add("is-valid");
            }

            if (order.value == '') {
                order.classList.add("is-invalid");
                return validatedFields = false;
            } else {
                order.classList.remove("is-invalid");
                order.classList.add("is-valid");
            }

            const fields = {
                name: fieldName.value,
                order: order.value,
            }

            return fields;

        }

        $('#buttonSaveCategory').click(function(event) {
            event.preventDefault();
            event.stopPropagation();

            var name = document.getElementById('nameCategory');
            var order = document.getElementById('orderCategory');
            var resultValidation = formValidator(name, order);
      
            if (resultValidation != false) {
                updateCategory(idCategory, resultValidation.name, resultValidation.order).then((result) => {
                    if (result == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Atualizado com sucesso',
                            html: 'Informações Atualizadas!',
                        });
                        $('#tbl_categories').bootstrapTable('refresh');
                        $('#modalCategory').modal('hide');
                    }
                });
            }

        });


        disableCategory = (id, active) => {
            return new Promise((resolve, reject) => {

                $.ajax({
                    url: urlBase + urlController + 'disableCategory',
                    method: 'PUT',
                    data: {
                        'data': JSON.stringify(active),
                        'id': JSON.stringify(id),
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


            });

        }

        updateCategory = (id, name, order) => {
            return new Promise((resolve, reject) => {

                $.ajax({
                    url: urlBase + urlController + 'update',
                    method: 'PUT',
                    data: {
                        'id': id,
                        'name': name,
                        'order': order,
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

        tbl_categories.bootstrapTable('destroy');
        $('#tbl_categories').bootstrapTable({
            url: urlBase + urlController + 'show',
            pagination: true,
            clickToSelect: false,

            search: true,
            columns: [{
                    field: 'state',
                    checkbox: false,
                    visible: false
                },
                {
                    field: 'id',
                    title: 'Item ID',
                    visible: false
                },
                {
                    
                    field: 'active',
                    title: 'Status',
                    sortable: false,
                    visible: true,
                    halign: 'center',
                    align: 'center',
                    width: '100',
                    widthUnit: 'px',
                    formatter: 'categoriesStatusFormatter',
                    events: 'categoryStatusEvents',

                },
                {
                    field: 'icon_name',
                    title: 'Logo',
                    align: 'center',
                    width: 50,
                    widthUnit: 'px',
                    formatter: function(value, row, index) {
                        return '<span class="material-icons">' + value + '</span>';
                    }
                },
                {
                    field: 'name',
                    title: 'Nome'
                },
                {
                    field: 'order',
                    title: 'Ordem',
                    visible: true,
                    align: 'center',
                    width: '100',
                    widthUnit: 'px',
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
                    events: 'categoryEditEvents',
                }
            ]
        })



    })
</script>


@endsection