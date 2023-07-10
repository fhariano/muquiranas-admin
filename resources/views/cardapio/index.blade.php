@extends('adminlte::page')


@section('content')
<div class="card card-default">


    <div class="card-header">
        <h1 style=text-align:center> <b> Cardápio </b> </h1>
    </div>


    <div class="card-body">

        <div class="modal fade" id="modalCardapio" tabindex="-1" role="dialog" aria-labelledby="modalCardapio_Label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCardapio_label">Cardapio</h5>
                    </div>

                    <div class="modal-body">

                        <form id="tblcardapioModal" class="needs-validation" novalidate>

                            @csrf

                            <div class="form-group col-12 d-flex justify-content-between">
                                <div class="col-3">
                                    <label for="short_name" class="col-form-label">Nome no Cardapio</label>
                                    <input type="text" id="shortName" maxlength="60" class="form-control" value="" required>
                                    <div id="shortNameFeedback" class="invalid-feedback">
                                        Preencha o Nome!
                                    </div>
                                </div>

                                <div class="col-3">
                                    <label for="short_description" class="col-form-label">Descrição</label>
                                    <input type="text" id="shortDescription" maxlength="35" class="form-control" required>
                                    <div id="descriptionFeedback" class="invalid-feedback">
                                        Preencha a Descrição!
                                    </div>
                                </div>

                                <div class="col-2">
                                    <label for="unity" class="col-form-label">Unidade</label>
                                    <input type="text" id="unity" class="form-control" maxlength="20" required>
                                    <div id="unityFeedback" class="invalid-feedback">
                                        Preencha a Unidade!
                                    </div>
                                </div>
                                <div class="col-2">
                                    <label for="price" class="col-form-label">Preço Base</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type=text id="priceBase" class="money2  text-right form-control" value="" aria-label="Amount " placeholder="0,00" required>
                                        <div id="priceBaseFeedback" class="invalid-feedback">
                                            Preencha o Preço
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <label for="order" class="col-form-label">Ordem</label>
                                    <input type="number" id="order" class="form-control" required>
                                    <div id="orderFeedback" class="invalid-feedback">
                                        Preencha a Unidade!
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="button" id="buttonSaveCardapio" class="btn btn-success">Salvar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div id="cardapioToolbar">
            </div>

            <div id="cardapio" class="col-12 table-responsive pt-1">
                <table id="tblCardapio" class="table table table-bordered table-hover"></table>
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
        var $tblCardapio = $('#tblCardapio');
        var urlBase = window.location.origin;
        var urlController = '/cardapio/';
        const buttonSaveCardapio = document.getElementById('buttonSaveCardapio');
        var idProductCardapio = '';
        var indexDetailsCardapioRow = 0;

        $('#transferirEstoque').click(function(event) {

            alert("Buscar no Estoque dos produtos na categoria: CERVEJA");
        })

        window.detailFormatterCardapio = function(index, row, $detail) {
            var html = '<div class="col-12 bg-secondary"><h4 class="mb-0 pb-1">Produtos no Cardápio &nbsp;&nbsp;<span class="infoProduct badge badge-dark small"></span></h4></div>'
            html += '<table id="tblDetailCardapio' + index + '" data-toggle="table" class="table table-sm table-condensed table-hover" cellspacing="0" width="100%"></table>';;
            return html;
        }

        getProductsFromCategoryDetail = (idCategories) => {
            return new Promise((resolve, reject) => {

                $.getJSON(urlBase + urlController + 'getProductsFromCategory/' + idCategories, function(result) {
                   
                    return resolve(result);
                });
            });
        }

        window.formaterImgProduct = function(index, row, $detail) {
            var html = '<div>';
            html += '<img style="height:50px" src="' + row.image_url + '">';
            html += '</div>';
            

            return html;

        }


        $tblCardapio.bootstrapTable({
            url: urlBase + urlController + 'categories',
            pagination: true,
            clickToSelect: false,
            search: false,
            searchTimeOut: 1500,
            searchAccentNeutralise: true,
            sortable: true,
            detailView: true,
            clickToSelect: true,
            uniqueId: 'id',
            detailFormatter: 'detailFormatterCardapio',
            events: 'cardapioEvents',
            columns: [{
                    field: 'id',
                    title: 'ID',
                    visible: false,
                },
                {
                    field: 'name',
                    title: 'Categoria',
                    visible: true,
                },
            ],
            onExpandRow: function(index, row, $detail) {
                $("#tblCardapio").find('.detail-view').each(function() {
                    if (!$(this).is($detail.parent())) {
                        $(this).prev().find('.detail-icon').click()
                    }
                });
                dataJson = [];

                getProductsFromCategoryDetail(row.id).then((result) => {
                    dataJson[index] = [];
                  
                    result.forEach(function(field, idx) {

                        dataJson[index].push({
                            'id': field.id,
                            'short_name': field.short_name,
                            'short_description': field.short_description,
                            'unity': field.unity,
                            'quantity':field.quantity,
                            'price_base': field.price_base =
                                new Intl.NumberFormat('pt-BR', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }).format(field.price_base),
                            'order': field.order,
                            'image_url': field.image_url

                        });
                    })

                }).then(() => {
                    indexDetailsCardapioRow = index;
                    $("#tblDetailCardapio" + index).bootstrapTable('load', dataJson[index]);

                });

                $("#tblDetailCardapio" + index).bootstrapTable({
              
                    search: true,
                    uniqueId: 'id',
                    shortOrder: 'order',
                    detailFormatter: 'actionCardapioFormatter',
                
                    columns: [{
                            field: 'id',
                            title: 'ID',
                            visible: false,
                        },
                        {
                            field: 'category_id',
                            title: 'ID CATEGORIA',
                            visible: false,
                        },
                        {
                            field: 'name',
                            title: 'Produto',
                            visible: false,
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
                            formatter: 'formaterImgProduct',
                        },
                        {
                            field: 'short_name',
                            title: 'Nome Cardápio',
                            visible: true,
                        },
                        {
                            field: 'short_description',
                            title: 'Descrição',
                            visible: true,
                        },
                        {
                            field: 'unity',
                            title: 'Unidade',
                            align: 'right',
                            visible: true,
                        },
                        {
                            field: 'price_base',
                            title: 'Preço Base',
                            align: 'right',
                            visible: true,
                        },
                        {
                            field: 'quantity',
                            title: 'Quantidade',
                            align: 'right',
                            visible: true,
                        },
                        {
                            field: 'order',
                            title: 'Ordem',
                            align: 'right',
                            visible: true,
                        },
                        {
                            field: 'name_category',
                            title: 'Categoria',
                            visible: false,
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
                            formatter: 'actionsCardapioFormatter',
                            events: 'cardapioEvents',
                        }

                    ],

                })

            }

        })


        buttonSaveCardapio.addEventListener('click', (event) => {
            event.preventDefault();
            var shortName = document.getElementById('shortName');
            var shortDescription = document.getElementById('shortDescription');
            var unity = document.getElementById('unity');
            var priceBase = document.getElementById('priceBase')
            var order = document.getElementById('order')

            var resultValidation = formValidator(shortName, shortDescription, unity, priceBase, order);
       ;
            if (resultValidation != false) {
                updateFieldsCardapio(resultValidation, idProductCardapio);
            }
        });

        function updateFieldsCardapio(fields, id) {
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
            

                    if (success == true) {


                        $tblCardapio.bootstrapTable('collapseRow', indexDetailsCardapioRow)
                        $tblCardapio.bootstrapTable('expandRow', indexDetailsCardapioRow)

                        Swal.fire({
                            icon: 'success',
                            title: 'Atualizado com Sucesso!',
                            html: 'Informações Atualizadas!',
                        });
                        $('#modalCardapio').modal('hide');

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

                 
                }


            })

        }

        function disableProuctCardapio(id) {

            $.ajax({
                url: urlBase + urlController + 'delete',
                method: 'PUT',
                data: {
                    'id': JSON.stringify(id)
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },
                success: function(success) {

                 

                    if (success == true) {

                        $tblCardapio.bootstrapTable('collapseRow', indexDetailsCardapioRow)
                        $tblCardapio.bootstrapTable('expandRow', indexDetailsCardapioRow)

                        Swal.fire({
                            icon: 'success',
                            title: 'OK',
                            html: 'Produto excluído com sucesso!',
                        });
                        $('#modalCardapio').modal('hide');

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

            }


            })

        }

        function formValidator(fieldShortName, fieldDescription, fieldUnity, fieldPriceBase, order) {
            var validatedFields = false;

            if (fieldShortName.value == '') {
                fieldShortName.classList.add("is-invalid");
                return validatedFields = false;
            } else {
                fieldShortName.classList.remove("is-invalid");
                fieldShortName.classList.add("is-valid");
            }

            if (fieldDescription.value == '') {
                fieldDescription.classList.add("is-invalid");
                return validatedFields = false;
            } else {
                fieldDescription.classList.remove("is-invalid");
                fieldDescription.classList.add("is-valid");

            }

            if (fieldUnity.value == '') {
                fieldUnity.classList.add("is-invalid");
                return validatedFields = false;
            } else {
                fieldUnity.classList.remove("is-invalid");
                fieldUnity.classList.add("is-valid");
            }

            var priceBase = fieldPriceBase.value.replace('.', '').replace(',', '.');
            if (fieldPriceBase.value == '' || priceBase <= 0) {
                fieldPriceBase.classList.add("is-invalid");
                return validatedFields = false;
            } else {
                fieldPriceBase.classList.remove("is-invalid");
                fieldPriceBase.classList.add("is-valid");
              
            }

            if (order.value == '') {
                order.classList.add("is-invalid");
                return validatedFields = false;
            } else {
                order.classList.remove("is-invalid");
                order.classList.add("is-valid");
            }


            const fields = {
                short_name: fieldShortName.value,
                short_description: fieldDescription.value,
                unity: fieldUnity.value,
                price_base: priceBase,
                order: order.value,
            }

            return fields;

        }

        //ABERTURA DO MODAL - MODAL PREÇO
        $('#modalCardapio').on('show.bs.modal', function() {});


        window.actionsCardapioFormatter = function(index, row, $detail) {
          
            var html= '@can("gerenciar_cardapio",$group_id)';
            html += '<div>';
            html += '<a href="javascript:void(0)" class="editCardapio" id="editCardapio" title="Editar Produto"><i class=" fas fa-pencil-alt fa-lg pr-2"></i></a>';
            html += '<a href="javascript:void(0)" class="delCardapio" id="delCardapio" title="Apagar Produto"><i class=" fas fa-times fa-lg text-danger pl-2"></i></a>';
            html += '</div>';
            html += '@endcan';

            return html;
        }

        window.cardapioEvents = {

            'click #editCardapio': function(e, value, row, index) {
                idProductCardapio = row.id;
               
                $('#shortName').val(row.short_name);
                $('#shortDescription').val(row.short_description);
                $('#unity').val(row.unity);
                $('#priceBase').val(row.price_base);
                $('#order').val(row.order);
                $("input").removeClass(["is-valid", "is-invalid"])
              
                $('#modalCardapio').modal('show');
              

            },
            'click #delCardapio': function(e, value, row, index) {
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Remover Produto do Cardápio?',
                    html: 'ATENÇÃO: Esse será removido do seu cardápio!',
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


    })
</script>


@endsection