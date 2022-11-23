@extends('adminlte::page')

@section('content')
<div class="card card-default">

    <div class="card-body">

        <div class="row">
            <div id="productsApiToolbar">

            </div>


            <div id="productsApi" class="col-12 table-responsive pt-1">
                <table id="tblProductsApi" class="table table table-bordered table-hover"></table>
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

        urlBase = window.location.origin;
        var urlController = '/transferencia/';
        var $tblProductsApi = $('#tblProductsApi');
        // botton = ('#save_products');


        transferirProductApi = () => {
                var fieldsProductsApi = JSON.stringify($tblProductsApi.bootstrapTable('getSelections'));
                //   console.log(fieldsProductsApi);
                 saveProductsCardapio(fieldsProductsApi);

 
            }


        function saveProductsCardapio(fields) {


            $.ajax({
                url: urlBase + urlController + 'store',
                method: 'POST',
                data: {
                    'data': fields,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },
                success: function(success) {
                     console.log('Retorno success:' + success);
                    if (success == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'OK',
                            html: 'Produtos Transferidos com sucesso.',
                        });
                    } else if (success == 2) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Atenção',
                            html: 'Já existe no cardápio o(s) ou um dos, produto(s) selecionado.',
                        });
                    } else if (success == 3) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Produto sem EAN!',
                            html: 'O produto sem EAN cadastrado, NÃO pode ser transferido para o cardápio.',
                        });

                    } else if (success == 4) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Categoria sem ID!',
                            html: 'Procure o administrador do sistema!',
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
                            title: 'Erro de comunicação!',
                            html: '<br>O sistema não está conseguindo se comunicar com o Banco de dados.',
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            html: 'Erro Crítico! <br>Contate o administrador.',
                        });

                    }

                }
            });

        }

        $tblProductsApi.bootstrapTable({

            url: urlBase + urlController + 'consultaApi', //nome 
            // showRefresh: true,
            toolbar: '#productsApiToolbar',
            pagination: true,
            clickToSelect: true,
            checkboxHeader: false,
            search: true,
            searchTimeOut: 1500,
            maintainMetaData: true,
            // searchOnEnterKey: true,
            searchAccentNeutralise: true,
            sortable: true,
            clickToSelect: true,
            events: 'selectProductApiEvents',
            uniqueId: 'id',
            // events: 'selectProductApiEvents',
            columns: [


                {

                    field: 'state',
                    checkbox: true,
                    visible: true,

                },
                {
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
                    visible: true,
                },
                {
                    field: 'short_name',
                    title: 'Nome Cardápio',
                    visible: true,
                },
                {
                    field: 'name_category',
                    title: 'Categoria',
                    visible: true,
                },
                {
                    field: 'ean_erp',
                    title: 'Código ean',
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
                    visible: true,
                },
                {
                    field: 'price_cost_erp',
                    title: 'Preço Custo',
                    visible: true,
                },
                {
                    field: 'price_sell',
                    title: 'Preço Venda',
                    visible: true,
                },
                {
                    field: 'price_base',
                    title: 'Preço Base',
                    visible: true,
                },
                {
                    field: 'quantity',
                    title: 'Quantidade',
                    align: 'right',
                    visible: true,
                },
                {
                    field: 'image_url',
                    title: 'IMG',
                    visible: true,
                },
                {
                    field: 'statusBar',
                    title: 'satus bar',
                    visible: false,
                },

            ],
            onLoadSuccess: function(data) {
                html = '@can("transferir_produto",$group_id)';
                html += '@if($statusBar != 1)';
                html += '';
                html += '<div class="bs-bars float-left">  <button type="button"  class="btn btn-sm btn-primary" role="button"  id="transferProductApi" title="Transferir Produto" aria-label="Transferir Produto" onclick="transferirProductApi();" ><i class="fas fa-random"></i> Trasnferir </button> <br> </br> <h3 align="center" id="headerTransferencia">Transferência de Produtos para o Cardápio</h3> </div>';
                html += '@endif';
                html +='@endcan';

                $('#productsApiToolbar').html(html);

            },
        });

    })
</script>


@endsection