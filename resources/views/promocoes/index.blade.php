@extends('adminlte::page')

@section('content')
<div class="card card-default">

    <div class="card-header">
        <h1 align="center">Preços e Promoções</h1>
    </div>

    <div class="card-body">
        <div class="row" align="center">
            <select class="promoList-basic-single form-control bg-primary d-flex justify-content-between" style="width:100%" id="promoList" name="promoList">
                <option class="font-weight-bold" selected disabled value="" align="center">LISTAS DE PREÇOS</option>
                @foreach($resultPromoList as $key => $value)
                <option value="{{$value['id'] }}">{{ $value['name'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="modal fade" id="modalPreco" tabindex="-1" role="dialog" aria-labelledby="modalPreco_Label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPreco_label"></h5>
                    </div>

                    <div class="modal-body">

                        <form id="tblPricePromo" class="needs-validation" novalidate>

                            @csrf
                            <select class="promoProduct-basic-single form-control " style="width:100%" id="promoProduct" align="center" name="promoProduct" required>
                                <option selected disabled value="" align="center"><b>PRODUTOS</b></option>
                                @foreach($resultProducts as $key => $value)
                                <option value="{{$value['id']}}">{{ $value['short_name'] }}</option>
                                @endforeach
                            </select>

                            <div id="promoProductFeedback" class="invalid-feedback">
                                Adicione um Produto
                            </div>

                            <div class="form-group col-12 d-flex justify-content-between">
                                <div class="col-4">
                                    <label for="hour_start" class="col-form-label">Hora Inicio</label>
                                    <input type="time" id="hourStart" class="form-control" value="" required>
                                    <div id="hourStartFeedback" class="invalid-feedback">
                                        Preencha Hora Inicio
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="hour_end" class="col-form-label">Hora Final</label>
                                    <input type="time" id="hourEnd" class="form-control" required>
                                    <div id="hourEndFeedback" class="invalid-feedback">
                                        Preencha Hora Final
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="price" class="col-form-label">Preço Promoção</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type=text id="price" class="money2  text-right form-control" value="" aria-label="Amount" placeholder="0,00" required>
                                        <div id="priceFeedback" class="invalid-feedback">
                                            Preencha o Preço
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="button" id="buttonSavePreco" class="btn btn-success"></button>
                    </div>
                </div>
            </div>
        </div>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


        <div class="row">
            <div id="promosListsToolbar">
            </div>

            <div id="promosLists" class="col-12 table-responsive pt-1">
                <table id="tblProductsPromosLists" class="table table table-bordered table-hover"></table>
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
        const inputHourStart = document.getElementById('hourEnd');
        var $tblProductsPromosLists = $('#tblProductsPromosLists');
        var urlBase = window.location.origin; //colocar no config
        var urlController = '/promocoes/';
        var $idList = ''; //recebe id Lista atual 
        var nameList = ''; //Name para mostrar no Header da tabela
        var idProductSelected = ''; //recebe o id do Produto Selecionado
        var hourStart = '';
        var hourEnd = '';
        var price = '';
        var indexDetailsRow = 0;
        var idPromo = '';


        // SELECT 2
        $('#promoList').select2();
        $('#promoProduct').select2({
            dropdownParent: $('#modalPreco .modal-content')
        });
        //   

        //EVENTOS 

        //ABERTURA DO MODAL - MODAL PREÇO
        $('#modalPreco').on('show.bs.modal', function() {

            $('.money2').mask("#.##0,00", {
                reverse: true
            });
            $("#modalPreco_label").html('Adicione um produto na lista: ' + '<b>' + nameList + '</b>');
        });
        //

        //RECUPERA O ID DO PRODUTO SELECIONADO 
        $("#promoProduct").change(function(event) {
            idProductSelected = $(this).val();
        });
        //


        inputHourStart.addEventListener('focusout', (event) => {
            event.preventDefault();

            const hourStar = document.getElementById('hourStart');
            const hourEnd = document.getElementById('hourEnd');

            if (hourEnd.value < hourStar.value) {
                hourEnd.classList.add("is-invalid");
                alert('HORA FINAL NÃO PODE SER MENOR QUE HORA INICIO')
                hourEnd.value = '';
            } else {
                if (hourEnd.value == '') {
                    hourEnd.classList.add("is-invalid");
                } else {
                    hourEnd.classList.remove("is-invalid");
                    hourEnd.classList.add("is-valid")
                }

            }
        })
   
        function formValidator(productValidator, hourStartValidator, hourEndValidator, priceValidator) {

            var validatedFields = false;

            if (productValidator.value == '') {
                productValidator.classList.add("is-invalid");
                return validatedFields = false;

            } else {
                productValidator.classList.remove("is-invalid");
                productValidator.classList.add("is-valid");
                // validatedFields = true;
            }

            if (hourStartValidator.value == '') {
                hourStartValidator.classList.add("is-invalid");
                return validatedFields = false;
            } else {
                hourStartValidator.classList.remove("is-invalid");
                hourStartValidator.classList.add("is-valid")
                // validatedFields = true;
            }

            if (hourEndValidator.value == '') {
                hourEndValidator.classList.add("is-invalid");
                return validatedFields = false;
            } else {
                if (hourEndValidator.value < hourStartValidator.value) {
                    hourEndValidator.classList.add("is-invalid");
                    alert('HORA FINAL NÃO PODE SER MENOR QUE HORA INICIO')
                    hourEndValidator.value = '';
                    return validatedFields = false;
                } else {
                    hourEndValidator.classList.remove("is-invalid");
                    hourEndValidator.classList.add("is-valid");
                    // validatedFields = true;
                }
            }

            var priceValue = priceValidator.value.replace('.', '').replace(',', '.');
            if (priceValidator.value == '' || priceValue <= 0) {
                priceValidator.classList.add("is-invalid");
                return validatedFields = false;
            } else {
                priceValidator.classList.remove("is-invalid");
                priceValidator.classList.add("is-valid");
                // validatedFields = true;
            }

        
            let fields = {
                product_id: productValidator.value,
                hourStart: hourStartValidator.value,
                hourEnd: hourEndValidator.value,
                price: priceValue,
                idList: idList,

            }

            return fields;
        }

        $('#buttonSavePreco').click(function(event) {
            event.preventDefault();
            event.stopPropagation();


            var product = document.getElementById('promoProduct');
            var hourStart = document.getElementById('hourStart');
            var hourEnd = document.getElementById('hourEnd');
            var price = document.getElementById('price');
            var id = document.getElementById('idPromo');
            
    
            var actionButtonSavePreco = event.target.name;
            var resultValidation = formValidator(product, hourStart, hourEnd, price);




            if (actionButtonSavePreco == 'InsertPrice' && resultValidation != false) {

                // console.log('ID produto vindo resultValidation: ' + resultValidation.product_id);
                savePriceProduct(resultValidation);

            } else {

                if (actionButtonSavePreco == 'UpdatePrice' && resultValidation != false) {

                    updatePriceProduct(resultValidation, idPromo);

                }


            }

        })


        function savePriceProduct(fields) {
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
                    console.log("Data " + success)

                    if (success == 2) {

                        Swal.fire({
                            icon: 'error',
                            title: 'Horários Incompatíveis',
                            html: 'Já existe um registro nessa faixa de horário.',
                        });

                    } else if (success == true) {
                        $tblProductsPromosLists.bootstrapTable('collapseRow', indexDetailsRow)
                        $tblProductsPromosLists.bootstrapTable('expandRow', indexDetailsRow)
                        Swal.fire({
                            icon: 'success',
                            title: 'Salvo!',
                            html: 'Novo preço cadastrado com sucesso!',
                        });
                        
                        $('#modalPreco').modal('hide');
                        $tblProductsPromosLists.bootstrapTable('refresh');

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            html: 'Algo deu errado!<br>Contate o administrador.',
                        });

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

        function updatePriceProduct(fields, id) {
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

                    if (success == 2) {

                        Swal.fire({
                            icon: 'error',
                            title: 'Horários Incompatíveis',
                            html: 'Já existe um registro nessa faixa de horário.',
                        });

                    } else if (success == true) {

                        $tblProductsPromosLists.bootstrapTable('collapseRow', indexDetailsRow)
                        $tblProductsPromosLists.bootstrapTable('expandRow', indexDetailsRow)

                        Swal.fire({
                            icon: 'success',
                            title: 'Atualizado com Sucesso!',
                            html: 'Informações Atualizadas!',
                        });
                        $('#modalPreco').modal('hide');

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

        function deletePriceProduct(id) {

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

                        $tblProductsPromosLists.bootstrapTable('collapseRow', indexDetailsRow)
                        $tblProductsPromosLists.bootstrapTable('expandRow', indexDetailsRow)

                        Swal.fire({
                            icon: 'success',
                            title: 'OK',
                            html: 'Preço excluído com sucesso!',
                        });


                    } else if (success == 2) {

                        Swal.fire({
                            icon: 'error',
                            title: 'Atenção',
                            html: 'Não existe esse registro no banco!',
                        });

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


        getProductsDetail = (idList,idProduct) => {
       
            return new Promise((resolve, reject) => {
                
             
                $.getJSON(urlBase + urlController + 'list/' + idList + '/product/' + idProduct, function(result) {

                    return resolve(result);
                });
            });
        }


        clickOpenModalPreco = (val) => {
            if (val == 1) {
                clearFieldsModalPreco();
            }
        }

        function clearFieldsModalPreco() {
            $('#hourStart').val('');
            $('#hourEnd').val('');
            $('#price').val('');
            $('#promoProduct').attr('disabled', false);
            $("#promoProduct").prop('selected', false);
            $('#buttonSavePreco').text('Cadastrar Preço');
            // $('#buttonSavePreco').attr('action', 'insertPrice');
            $('#buttonSavePreco').removeAttr('name', 'UpdatePrice');
            $("#buttonSavePreco").attr('name', 'InsertPrice');
            $("input").removeClass(["is-valid", "is-invalid"]);
            $("select").removeClass(["is-invalid"]);
            $('#modalPreco').modal('show');
        };



        window.detailFormatterPromosLists = function(index, row, $detail) {
            var html = '<div class="col-12 bg-secondary"><h4 class="mb-0 pb-1">Informações do Produto &nbsp;&nbsp;<span class="infoProduct badge badge-dark small"></span></h4></div>'
            html += '<table id="detail-product' + index + '" data-toggle="table" class="table table-sm table-condensed table-hover" cellspacing="0" width="100%"></table>';;
            return html;
        };

        window.actionsProductPromoFormatter = function(index, row, $detail) {
            var html =  '@can("gerenciar_promocoes",$group_id)';
            html += '<div>';
            html += '<a href="javascript:void(0)" class="editPromo" id="editPromo" title="Editar Promo" onclick="clickOpenModalPreco(0);"><i class=" fas fa-pencil-alt fa-lg pr-2"></i></a>';
            html += '<a href="javascript:void(0)" class="delPromo" id="delPromo" title="Apagar Promo"><i class=" fas fa-times fa-lg text-danger pl-2"></i></a>';
            html += '</div>';
            html += '@endcan';

            return html;

        }

        window.productPromoEvents = {

            'click #editPromo': function(e, value, row, index) {
                idPromo = row.id;
                $('#hourStart').val(row.hour_start);
                $('#hourEnd').val(row.hour_end);
                $('#price').val(row.price);
                $('#promoProduct').attr('disabled', 'disabled');
                $("#promoProduct").val(row.product_id).change().prop('selected', true);
                $('#buttonSavePreco').text('Salvar Preço')
                $('#buttonSavePreco').removeAttr('name', 'InsertPrice');
                $("#buttonSavePreco").attr('name', 'UpdatePrice');
                $("input").removeClass(["is-valid", "is-invalid"])
                $("select").removeClass(["is-invalid"])
                $('#modalPreco').modal('show');             

            },
            'click #delPromo': function(e, value, row, index) {
                Swal.fire({
                      position: 'center',
                      icon: 'warning',
                      title: 'Apagar Preço?',
                      html: 'ATENÇÃO: Esse preço será excluído!',
                      allowOutsideClick: false,
                      showCloseButton: true,
                      showCancelButton: true,
                      focusConfirm: false,
                      confirmButtonText: '<i class="fa fa-thumbs-up pr-1 pl-1"></i> SIM ',
                      cancelButtonText:'<i class="fa fa-thumbs-down pr-1 pl-1"></i> CANCELAR',
                    }).then((result) => {
                        if(result.isConfirmed){
                            deletePriceProduct(row.id);  
                        }
                    });

                

            },



        }

        $("#promoList").change(function(event) {
            idList = $(this).val();
            nameList = this.options[this.selectedIndex].text

            $tblProductsPromosLists.bootstrapTable('destroy');
            $tblProductsPromosLists.bootstrapTable({

                url: urlBase + urlController + idList, //nome 
                pagination: true,
                toolbar: '#promosListsToolbar',
                clickToSelect: true,
                search: true,
                searchTimeOut: 1500,
                searchAccentNeutralise: true,
                sortable: true,
                detailView: true,
                detailFormatter: 'detailFormatterPromosLists',
                uniqueId: 'product_id',
                events: 'createPriceEvents',
                columns: [{
                        field: 'id',
                        title: 'ID',
                        visible: false,
                    },
                    {
                        field: 'promos_list_id',
                        visible: false,
                    },
                    {
                        field: 'product_id',
                        visible: false,
                    },
                    {
                        field: 'short_name',
                        title: 'Produto'
                    },

                ],
                onLoadSuccess: function(data) {
                    html = '@can("gerenciar_promocoes",$group_id)'
                    html += '';
                    html += '<div class="bs-bars float-left">  <button class="btn btn-sm btn-success" id="openModalPromo" type="button" title="Adicionar Produto" aria-label="Adicionar Produto"  onclick="clickOpenModalPreco(1);"><i class="fas fa-plus pr-2"></i> Produto </button> <br> </br> <h4 align="center" id="headerListPrice">Lista: <b> ' + nameList + ' </b> </h4>  </div>';
                    html += '@endcan';
                    $('#promosListsToolbar').html(html);

                },
                onExpandRow: function(index, row, $detail) {
                    //Bloquei abertura de varios detalhes
                    $('#tblProductsPromosLists').find('.detail-view').each(function() {
                        if (!$(this).is($detail.parent())) {
                            $(this).prev().find('.detail-icon').click()
                        }
                    });
                             
                    var dataJson = [];
               
                    const productId = row ? row.product_id : 0;
                    getProductsDetail(idList,productId).then((result) => {
                        dataJson[index] = [];
                        result.forEach(function(field, idx) {

                            dataJson[index].push({

                                'id': field.id,
                                'promos_list_id': field.promos_list_id,
                                'product_id': field.product_id,
                                'hour_start': field.hour_start.substring(0, 5),
                                'hour_end': field.hour_end.substring(0, 5),
                                'price': field.price =
                                new Intl.NumberFormat('pt-BR', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }).format(field.price),
                                'promos_list_id': field.idList
                                
                            });
                        })


                    }).then(() => {

                        indexDetailsRow = index;
                        $("#detail-product" + index).bootstrapTable('load', dataJson[index]);

                    });

                    $("#detail-product" + index).bootstrapTable({
                        uniqueId: 'id',
                        columns: [{
                                field: 'id',

                                visible: false,
                            },
                            {
                                field: 'promos_list_id',
                                visible: false,
                            },
                            {
                                field: 'product_id',
                                visible: false,
                            },
                            {
                                field: 'hour_start',
                                title: 'Hora Inicio',
                                align: 'center'
                            },
                            {
                                field: 'hour_end',
                                title: 'Hora Final',
                                align: 'center'
                            },
                            {
                                field: 'price',
                                title: 'Preço',
                                align: 'right'

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
                                formatter: 'actionsProductPromoFormatter',
                                events: 'productPromoEvents',
                            }

                        ],


                    })

                }
            })

        });








    })
</script>



@endsection