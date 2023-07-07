@extends('adminlte::page')

@section('content')
<div class="card card-default">

    <div class="card-body">

        <div class="row" id="inputRow" align="center">
            <div class="col-1">

                <div class="input-group">

                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-list" aria-hidden="true">&nbsp;&nbsp;</i> Lista Ativa: &nbsp;<b><span
                                    style="color: green;">{{ $nomeDaLista }}</span></b>
                            &nbsp;&nbsp;<i class="fa fa-list" aria-hidden="true"></i>
                        </span>
                    </div>

                </div>
            </div>
        </div>

        <br>



        <div class="row sr-only" id="selectBars" align="center">
            <select class="js-selectBar-ajax form-control bg-primary d-flex justify-content-between" style="width:100%"
                id="selectBar" name="selectBar">
                <option class="font-weight-bold sr-only" selected disabled value="" align="center">TODOS</option>
                @foreach($fieldsBar as $key => $value)
                <option value="{{ $value->bar_id }}">{{ $value->nameBar }}</option>
                @endforeach
            </select>
        </div>

        <div class="row sr-only" id="selectCategories" align="center">
            <select id="categoriesBar" style="width:100%;display:none"></select>
        </div>

    </div>

    <div class="container-fluid">


        <div class="bd-example sr-only">
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12 col-sm-6 col-md-3 sr-only" id='clsCardReceita'></div>
            <div class="col-12 col-sm-6 col-md-3 sr-only" id='clsCardITotaltens'></div>
            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-3 sr-only" id='clsCardTotal'></div>
            <div class="col-12 col-sm-6 col-md-3 sr-only" id='clsCardMedia'></div>




            <div class="card-body">


                <div class="card sr-only" id='tabelaProdutos'>
                    <div class="card-header border-0">
                        <h3 class="card-title">TABELA DE PRODUTOS</h3>
                        <div class="card-tools"></div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Total (R$)</th>
                                    <th>Média (R$)</th>
                                    <th>Preço Base (R$)</th>

                                </tr>
                            </thead>
                            <tbody id="tabelaProdutosBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


</div>

@endsection

@section('footer')
<div class="footer">
    Copyright © Muquiranas Bar -
    <?php echo date('Y'); ?>
</div>
@endsection



@section('js')

<script>
$(function() {

    const URL_BASE = window.location.origin;
    const ROTA_CATEGORIES = '/categorias/';
    const ROTA_HOME = '/home/';
    const ROTA_BAR = '/bar/';
    const URL_CONTROLLER = '/resultBars';
    let valorReceita = <?= $receitas ?>;
    let barUser = <?= $idBar ?>;
    let nameBar = '<?= $nameBar ?>';
    let groupUser = <?= $groupUser ?>;
    let idBarSelecionado = 1;
    let control = 0;



    $('#selectBar').select2();
    $('#categoriesBar').select2();

    const selectBar = $('#selectBar');
    const selectCategories = $('#categoriesBar');

    cardReceita(valorReceita);

    function numberFormatPtBr(valor) {
        return new Intl.NumberFormat('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(valor);
    }
    // Funções para criação dos cards

    function cardReceita(valor) {


        // media = numberFormatPtBr(valor);
        media = valor ? numberFormatPtBr(valor) : 0;
        let cardReceita = '';
        cardReceita += '<div class="info-box">';
        cardReceita +=
            '<span class="info-box-icon bg-success elevation-1"> <i class="fas fa-qrcode"></i> </span>';
        cardReceita += '<div class="info-box-content">';
        cardReceita += '<span class="info-box-text-receita"><b> RECEITAS </b></span>';
        cardReceita += '<span class="info-box-number-receita">';
        cardReceita += 'R$ ' + media;

        cardReceita += '</span>';
        cardReceita += '</div>';
        cardReceita += '</div>';
        $('#clsCardReceita').append(cardReceita);
        $("#clsCardReceita").removeClass("sr-only");

    }


    function cardItens(valor, icon) {
        let cardTotalItens = '';
        cardTotalItens += '<div class="info-box mb-3" divBox>';
        cardTotalItens +=
            '     <span class="info-box-icon cardCategoria bg-danger elevation-1 material-icons">' + icon +
            '</span>';
        cardTotalItens += '      <div class="info-box-content">';
        cardTotalItens += '             <span class="info-box-text"><b>ITENS</b></span>';
        cardTotalItens += '             <span class="info-box-number-itens">';
        cardTotalItens += valor;
        cardTotalItens += '             </span>';
        cardTotalItens += '       </div>';
        cardTotalItens += '       </div>';
        cardTotalItens += '       </div>';
        $('#clsCardITotaltens').append(cardTotalItens);
        $("#clsCardITotaltens").removeClass("sr-only");
    }

    function cardTotal(valor, icon) {
        var total = numberFormatPtBr(valor);
        let cardTotalp = '';
        cardTotalp += '<div class="info-box mb-3" divBox>';
        cardTotalp += '<span class="info-box-icon cardCategoria bg-info elevation-1 material-icons">' + icon +
            '</span>';
        cardTotalp += '<div class="info-box-content">';
        cardTotalp += '<span class="info-box-text"><b>TOTAL</b></span>';
        cardTotalp += '<span class="info-box-number-total">';
        cardTotalp += 'R$ ' + total;
        cardTotalp += '</span>';
        cardTotalp += '</div>';
        cardTotalp += '</div>';

        $('#clsCardTotal').append(cardTotalp);
        $("#clsCardTotal").removeClass("sr-only");
    }

    function cardMedia(valor, icon) {
        media = numberFormatPtBr(valor);
        let cardMedia = '';
        cardMedia += '<div class="info-box mb-3" divBox>';
        cardMedia += '<span class="info-box-icon cardCategoria bg-warning elevation-1 material-icons">' + icon +
            '</span>';
        cardMedia += '<div class="info-box-content">';
        cardMedia += '<span class="info-box-text"><b>MÉDIA</b></span>';
        cardMedia += '<span class="info-box-number-media">';
        cardMedia += '<span class="info-box-number-media">';
        cardMedia += 'R$ ' + media + '';
        cardMedia += '</span>';
        cardMedia += '</div>';
        cardMedia += '</div>';

        $('#clsCardMedia').append(cardMedia);
        $("#clsCardMedia").removeClass("sr-only");

    }

    function updateValueCardReceita(newValue) {
        //  valueReceitaFormatado = numberFormatPtBr(newValue);
        valueReceitaFormatado = newValue ? numberFormatPtBr(newValue) : '0,00';

        $("#clsCardReceita").removeClass("sr-only");

        $('.info-box-number-receita').text('R$ ' + valueReceitaFormatado);
        $('.info-box-text-receita').text('RECEITA');
    }

    function updateValueCardItens(newValue) {
        $("#clsCardITotaltens").removeClass("sr-only");
        $('.info-box-number-itens').text(newValue);


    }

    function updateValueCardTotal(newValue) {
        valueTotalFormatado = numberFormatPtBr(newValue);
        $("#clsCardTotal").removeClass("sr-only");
        $('.info-box-number-total').text('R$ ' + valueTotalFormatado);


    }

    function updateValueCardMedia(newValue) {
        valueMediaFormatado = numberFormatPtBr(newValue);
        $("#clsCardMedia").removeClass("sr-only");
        $('.info-box-number-media').text('R$ ' + valueMediaFormatado);

    }

    function updateIconCards(iconCard) {
        $('.cardCategoria').text(iconCard);
    }


    // Função condicional, onde mostrará ou não o selctBar e o CardReceitas. 
    if (groupUser != 6) {

        $('.bd-example').removeClass("sr-only");
        $('#categoriesBar').empty();
        $("#clsCardReceita").addClass("sr-only");
        $("#clsCardITotaltens").addClass("sr-only");
        $("#clsCardTotal").addClass("sr-only");
        $("#clsCardMedia").addClass("sr-only");
        getReceitaBarForCard(barUser);
        getCategoriesForSelect(barUser);
        atualizarNomeBar(nameBar);

    } else {


        $("#selectBars").removeClass("sr-only");
        $("#clsCardReceita").removeClass("sr-only");
        selectBar.change(function(event) {


            atualizarNomeBar($(this).find("option:selected").text());

            //Fazer verificação onde mudando o id do bar, precisa ( atualizar o carde receita, esconder os outrs cards e a tabela de produtos. )
            barUser = $(this).val();

            //função ajax para atualizar o valor da receita baseado no is do bar selecionado.

            $('.bd-example').removeClass("sr-only");
            $('#categoriesBar').empty();
            $("#tabelaProdutos").addClass("sr-only");
            $("#clsCardReceita").addClass("sr-only");
            $("#clsCardITotaltens").addClass("sr-only");
            $("#clsCardTotal").addClass("sr-only");
            $("#clsCardMedia").addClass("sr-only");
            getReceitaBarForCard(barUser);
            getCategoriesForSelect(barUser);

        });

    }

    function atualizarNomeBar(name) {

        $("#nomeDoBar").text('Muquiranas ' + name);
    }


    function getReceitaBarForCard(idBar) {

        $.ajax({
            type: "POST",
            url: URL_BASE + ROTA_BAR + 'requestValorReceita',
            data: {
                'idBar': idBar,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(success) {

                updateValueCardReceita(success);

            }
        });


    }

    function getCategoriesForSelect(idBar) {

        if (idBar) {
            $("#categoriesBar").show();
            $.ajax({
                type: "POST",
                url: URL_BASE + ROTA_CATEGORIES + 'getCategories',
                data: {
                    'idBarSelecionado': idBar,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                success: function(categories) {

                    $('.bd-example').addClass("sr-only");
                    $("#categoriesBar").append(
                        '<option class="font-weight-bold" selected disabled value="" align="center">CATEGORIAS</option>'
                    )

                    $.each(categories, function(key, value) {

                        $("#selectCategories").removeClass("sr-only");
                        $("#categoriesBar").append('<option value="' + value['id'] +
                            '">' + value['name'] + '<option>');
                    });

                    $("#categoriesBar").trigger("change");
                }
            });
        } else {
            $("categoriesBar").hide();
        }

    }

    selectCategories.change(function(event) {

        idCategories = $(this).val();
        $("div").remove(".divBox");

        if (idCategories) {

            if (control != 1) {
                // icon = 'sports_bar';

                $('.bd-example').removeClass("sr-only");

                getConsolidadoDados(barUser, idCategories).then((result) => {


                    $('.bd-example').addClass("sr-only");
                    if (result.noData != true) {
                        $("#tabelaProdutos").removeClass("sr-only");
                        $("#clsCardReceita").removeClass("sr-only");

                    }
                    cardTotal(result.totalDia, result.category_icon);
                    cardItens(result.qtdTotalDia, result.category_icon);
                    cardMedia(result.mediaDia, result.category_icon);
                    popularTabelaProdutos(result.fieldsProducts);

                }).catch(function(error) {
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Atenção!',
                        html: 'Ocorreu um erro ao buscar os dados consolidados. Por favor, tente novamente mais tarde.',
                    });
                    
                  
                });

                control = 1;
            } else {

                $("#tabelaProdutos").addClass("sr-only");
                $("#clsCardITotaltens").addClass("sr-only");
                $("#clsCardTotal").addClass("sr-only");
                $("#clsCardMedia").addClass("sr-only");
                $('.bd-example').removeClass("sr-only");

                getConsolidadoDados(barUser, idCategories).then((result) => {

                    $('.bd-example').addClass("sr-only");
                    if (result.noData != true) {

                        $("#clsCardITotaltens").removeClass("sr-only");
                        $("#clsCardTotal").removeClass("sr-only");
                        $("#clsCardMedia").removeClass("sr-only");
                        $("#tabelaProdutos").removeClass("sr-only");
                    }
                    updateValueCardTotal(result.totalDia);
                    updateValueCardItens(result.qtdTotalDia);
                    updateValueCardMedia(result.mediaDia);
                    updateIconCards(result.category_icon);
                    popularTabelaProdutos(result.fieldsProducts);

                }).catch(function(error) {
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Atenção!',
                        html: 'Ocorreu um erro ao buscar os dados consolidados. Por favor, tente novamente mais tarde.',
                    });
                    
                  
                });

            }

        }
    })


    function popularTabelaProdutos(produtos) {

        var tabelaBody = $('#tabelaProdutosBody');
        tabelaBody.empty(); // limpa o conteúdo anterior da tabela

        $.each(produtos, function(i, produto) {
            var imgSrc = produto.product_image;
            var nomeProduto = produto.product_name;
            var quantidade = produto.quantity;
            var total = numberFormatPtBr(produto.total)
            var media = numberFormatPtBr(produto.mediaPorProduto)
            var preco = numberFormatPtBr(produto.price)

            var tr = $('<tr>');
            var tdProduto = $('<td>');
            var img = $('<img>').attr('src', imgSrc).addClass('img-circle img-size-32 mr-2');
            tdProduto.append(img).append(nomeProduto);
            var tdQuantidade = $('<td>').text(quantidade);
            var tdTotal = $('<td>').text(total);
            var tdMedia = $('<td>').text(media);
            var tdPreco = $('<td>').text(preco);

            tr.append(tdProduto).append(tdQuantidade).append(tdTotal).append(tdMedia).append(tdPreco);

            tabelaBody.append(tr);
        });
    }




    function getConsolidadoDados(idBar, idCategoria) {
        // Validar as entradas do usuário
        idBar = parseInt(idBar) || 0;
        idCategoria = parseInt(idCategoria) || 0;

        var dados = {
            idBar: idBar,
            idCategoria: idCategoria,
            _token: $('meta[name="csrf-token"]').attr('content'),
        };

        // Retornar uma nova promise
        return new Promise(function(resolve, reject) {
            $.ajax({
                type: "POST",
                url: URL_BASE + ROTA_HOME + "requestConsolidadoDados",
                data: dados,
                dataType: "json",
                success: function(response) {

                    resolve(response);
                },
                error: function(xhr, textStatus, errorThrown) {

                    reject(errorThrown);
                },
            });
        });
    }



    // function getConsolidadoDados(idBar,idCategoria){

    //     // Validar as entradas do usuário
    //     idBar = parseInt(idBar) || 0;
    //     idCategoria = parseInt(idCategoria) || 0;

    //     var dados = {
    //         idBar:idBar,
    //         idCategoria:idCategoria,
    //         _token: $('meta[name="csrf-token"]').attr('content')
    //     };

    //     $.ajax({
    //         type:"POST",
    //         url: URL_BASE + ROTA_HOME + 'requestConsolidadoDados',
    //         data: dados,
    //         dataType:"json",
    //         success:function(response){
    //            
    //             return response;
    //         },
    //         error:function(xhr,textStatus,errorThrown){
    //           
    //         }
    //     })


    // }

});
</script>


@endsection