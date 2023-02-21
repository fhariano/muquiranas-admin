@extends('adminlte::page')

@section('content')
<div class="card card-default">

    <div class="card-body">
        <div class="row" align="center">
            <!-- <select class="selectBar-basic-single form-control bg-primary d-flex justify-content-between" style="width:100%" id="selectBar" name="selectBar"> -->
            <select class="js-selectBar-ajax form-control bg-primary d-flex justify-content-between" style="width:100%" id="selectBar" name="selectBar">
                <option class="font-weight-bold sr-only" selected disabled value="" align="center">TODOS</option>
                @foreach($fieldsBar as $key => $value)
                <option value="{{$value['id'] }}">{{ $value['name'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="row sr-only" id="selectCategories" align="center">
            <!-- <select  class="selectCategory-basic-single form-control bg-primary d-flex justify-content-between" style="width:100%" id="categoriesBar" name="categoriesBar" style="display:none"> -->
            <select id="categoriesBar" style="width:100%;display:none">
                <!-- <option class="font-weight-bold" selected disabled value="" align="center">CATEGORIAS</option>
                @foreach($categoriesAll as $key => $value)
                <option value="{{$value['id'] }}">{{ $value['name'] }}</option>
                @endforeach -->
            </select>
        </div>

    </div>

    <!-- <div class="card-body" >


    </div> -->



    <div class="container-fluid">

        <div class="row">
            <div class="col-12 col-sm-6 col-md-3" id='clsCardReceita'></div>

            <div class="col-12 col-sm-6 col-md-3 sr-only" id='clsCardITotaltens'></div>
            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-3 sr-only" id='clsCardTotal'></div>

            <div class="col-12 col-sm-6 col-md-3 sr-only" id='clsCardMedia'></div>
            <div class="card-body">



                <div class="card sr-only" id='tabelaProdutos'>
                    <div class="card-header border-0">
                        <h3 class="card-title">TABELA DE PRODUTOS</h3>
                        <div class="card-tools">


                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Preço</th>
                                    <th>Média</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>


                                        <img src="https://s3-sa-east-1.amazonaws.com/cake-app-files/public/customers/11083/products/7583007/thumb/d7e95e59-3e56-49d6-8f4c-809a597499f6.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                                        STELLA ARTOIS
                                    </td>
                                    <td>3 </td>
                                    <td>$7,00</td>
                                    <td>
                                        <!-- <small class="text-success mr-1">
                                        <i class="fas fa-arrow-up"></i>
                                        12%
                                    </small> -->
                                        12,00
                                    </td>

                                </tr>



                                <tr>
                                    <td>
                                        <img src="https://s3-sa-east-1.amazonaws.com/cake-app-files/public/customers/11083/products/7689807/47477094-2cea-4d34-bf7a-a0d1024ed1f4.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                                        BRAHMA EXTRA WEISS
                                    </td>
                                    <td>2 </td>
                                    <td>$5,00</td>
                                    <td>
                                        <!-- <small class="text-warning mr-1">
                                        <i class="fas fa-arrow-down"></i>
                                        0.5%
                                    </small> -->
                                        10,00
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://s3-sa-east-1.amazonaws.com/cake-app-files/public/customers/11083/products/7543657/aa1bf253-1bae-4272-bc1e-4486c66115bc.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                                        SKOL
                                    </td>
                                    <td>4 </td>
                                    <td>$6,00</td>
                                    <td>
                                        <!-- <small class="text-danger mr-1">
                                        <i class="fas fa-arrow-down"></i>
                                        3%
                                    </small> -->
                                        9,00
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://s3-sa-east-1.amazonaws.com/cake-app-files/public/customers/11083/products/7689812/45d81c9f-d6e7-46f4-8a9a-9b791ca3178c.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                                        CERVEJA BECKS
                                        <!-- <span class="badge bg-danger">NEW</span> -->
                                    </td>
                                    <td>6</td>
                                    <td>$8,00</td>
                                    <td>
                                        <!-- <small class="text-success mr-1">
                                        <i class="fas fa-arrow-up"></i>
                                        63%
                                    </small> -->
                                        11,00
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- <div class="card-body"> -->



    <!-- <div class="card">
            <div class="card-header">
                <h3 class="card-title"><b> Consolidade por Categória <b> </h3>
            </div> -->

    <!-- <div class="card-body"> -->
    <!-- <div class="row"> -->
    <!-- <div class="col-md-8">
                        <div class="chart-responsive">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <div display>
                                <canvas id="myChart" height="172" width="344"
                                    style="display: block; width: 516px; height: 258px;"
                                    class="chartjs-render-monitor"></canvas>
                            </div>



                        </div>

                    </div>

                    <div class="col-md-4">
                        <ul class="chart-legend clearfix">
                            <li><i class="far fa-circle text-secondary"></i> Cervejas</li>
                            <li><i class="far fa-circle text-danger"></i> Combos e Pra Levar</li>
                            <li><i class="far fa-circle text-success"></i> Comidinhas </li>
                            <li><i class="far fa-circle text-warning"></i> Garrafas</li>
                            <li><i class="far fa-circle text-info"></i> Não Alcoólicos</li>
                            <li><i class="far fa-circle text-primary"></i> Drinks e Doses</li>
                        </ul>
                    </div>

                </div>

            </div>
            -->
    <!-- <div class="card-footer p-0">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <?=$name?>
                            <span class="float-right text-success">
                                ?= $qtdTotalDia ?>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            Drinks e Doses
                            <span class="float-right text-success">
                                5
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            Não Alcoólicos
                            <span class="float-right text-success">
                                15
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            Garrafas
                            <span class="float-right text-success">
                                15
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            Comidinhas
                            <span class="float-right text-success">
                                15
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            Combos e Pra Levar
                            <span class="float-right text-success">
                                15
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="chart-container" style="position: relative; height:30vw; width:60vw">

                <canvas id="myChart"></canvas>

            </div>
        </div>

        </div> -->
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
        valorReceita = '250,00';

        let barUser = 0;
        let idBarSelecionado = 1;
        let control = 0;

        $('#selectBar').select2();
        $('#categoriesBar').select2();

        const selectBar = $('#selectBar');
        const selectCategories = $('#categoriesBar');

        cardReceita(valorReceita);

        // Funções para criação dos cards

        function cardReceita(valor) {

            let cardReceita = '';
            cardReceita += '<div class="info-box">';
            cardReceita +=
                '<span class="info-box-icon bg-success elevation-1"> <i class="fas fa-qrcode"></i> </span>';
            cardReceita += '<div class="info-box-content">';
            cardReceita += '<span class="info-box-text-receita"><b> RECEITAS </b></span>';
            cardReceita += '<span class="info-box-number-receita">';
            cardReceita += '$' + <?=$receitas?>;

            cardReceita += '</span>';
            cardReceita += '</div>';
            cardReceita += '</div>';
            $('#clsCardReceita').append(cardReceita);

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
            cardTotalItens += '              $' + valor;
            cardTotalItens += '             </span>';
            cardTotalItens += '       </div>';
            cardTotalItens += '       </div>';
            cardTotalItens += '       </div>';
            $('#clsCardITotaltens').append(cardTotalItens);
            $("#clsCardITotaltens").removeClass("sr-only");
        }

        function cardTotal(valor, icon) {

            let cardTotalp = '';
            cardTotalp += '<div class="info-box mb-3" divBox>';
            cardTotalp += '<span class="info-box-icon cardCategoria bg-info elevation-1 material-icons">' + icon +
                '</span>';
            cardTotalp += '<div class="info-box-content">';
            cardTotalp += '<span class="info-box-text"><b>TOTAL</b></span>';
            cardTotalp += '<span class="info-box-number-total">';
            cardTotalp += '$' + valor;
            cardTotalp += '</span>';
            cardTotalp += '</div>';
            cardTotalp += '</div>';

            $('#clsCardTotal').append(cardTotalp);
            $("#clsCardTotal").removeClass("sr-only");
        } 
   
        function cardMedia(valor, icon) {

            let cardMedia = '';
            cardMedia += '<div class="info-box mb-3" divBox>';
            cardMedia += '<span class="info-box-icon cardCategoria bg-warning elevation-1 material-icons">' + icon +
                '</span>';
            cardMedia += '<div class="info-box-content">';
            cardMedia += '<span class="info-box-text"><b>MÉDIA</b></span>';
            cardMedia += '<span class="info-box-number-media">';
            cardMedia += '<span class="info-box-number-media">';
            cardMedia += '$' + valor + '';
            cardMedia += '</span>';
            cardMedia += '</div>';
            cardMedia += '</div>';

            $('#clsCardMedia').append(cardMedia);
            $("#clsCardMedia").removeClass("sr-only");

        }

        function updateValueCardReceita(newValue) {
            $("#clsCardReceita").removeClass("sr-only");
            $('.info-box-number-receita').text('$' + newValue);
            $('.info-box-text-receita').text('RECEITA');
        }

        function updateValueCardItens(newValue) {
            $("#clsCardITotaltens").removeClass("sr-only");
            $('.info-box-number-itens').text(newValue);


        }

        function updateValueCardTotal(newValue, iconCard) {
            $("#clsCardTotal").removeClass("sr-only");
            $('.info-box-number-total').text('$' + newValue);
            $('.cardCategoria').text(iconCard);

        }

        function updateValueCardMedia(newValue) {
            $("#clsCardMedia").removeClass("sr-only");
            $('.info-box-number-media').text('$' + newValue);

        }






        selectBar.change(function(event) {

            //Fazer verificação onde mudando o id do bar, precisa ( atualizar o carde receita, esconder os outrs cards e a tabela de produtos. )
            barUser = $(this).val();

            //função ajax para atualizar o valor da receita baseado no is do bar selecionado.

            $('#categoriesBar').empty();
            $("#clsCardReceita").addClass("sr-only");
            $("#clsCardITotaltens").addClass("sr-only");
            $("#clsCardTotal").addClass("sr-only");
            $("#clsCardMedia").addClass("sr-only");
            getReceitaBarForCard(barUser);
            getCategoriesForSelect(barUser);

        });

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

            if (idBarSelecionado) {
                $("#categoriesBar").show();
                $.ajax({
                    type: "POST",
                    url: URL_BASE + ROTA_CATEGORIES + 'getCategories',
                        data: {
                            'idBarSelecionado': idBarSelecionado,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                        success: function(categories) {


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

        // function getCategoriesForSelect(idBar) {

        //     if (idBarSelecionado) {
        //         $("#categoriesBar").show();
        //         $.ajax({
        //             type: "POST",
        //             url: URL_BASE + ROTA_HOME + 'getCategories',
        //                 data: {
        //                     'idBarSelecionado': idBarSelecionado,
        //                 },
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                 },
        //                 dataType: "json",
        //                 success: function(categories) {

        //                     console.log('categorias' + categories);
        //                     $("#categoriesBar").append(
        //                         '<option class="font-weight-bold" selected disabled value="" align="center">CATEGORIAS</option>'
        //                     )

        //                     $.each(categories, function(key, value) {
        //                         $("#selectCategories").removeClass("sr-only");

        //                         $("#categoriesBar").append('<option value="' + value['id'] +
        //                             '">' + value['name'] + '<option>');
        //                     });

        //                     $("#categoriesBar").trigger("change");
        //                 }
        //         });
        //     } else {
        //         $("categoriesBar").hide();
        //     }

        // }

        selectCategories.change(function(event) {

            idCategories = $(this).val();
            $("div").remove(".divBox");

            if (idCategories) {

                if (control != 1) {
                    icon = 'sports_bar';
                    $(event.target).parent("#divBoxTotalItens").remove();
                    consolidadoFields = getConsolidadoDados(idBarSelecionado, idCategories);
                    cardItens(<?=$qtdTotalDia?>, icon);
                    cardMedia(<?=$mediaDia?>, icon);
                    cardTotal(<?=$totalDia?>, icon);
                    $("#tabelaProdutos").removeClass("sr-only");
                    control = 1;
                } else {
                    qtdIten = '177';
                    qtdTotal = '277';
                    qtdmedia = '377';
                    icon = 'delivery_dining';
                    consolidadoFields = getConsolidadoDados(barUser, idCategories);
                    updateValueCardItens(qtdIten);
                    updateValueCardTotal(qtdTotal, icon);
                    updateValueCardMedia(qtdmedia);

                    //criar a função que mudará a informações da tabela

                }

            }
        })


        // function getConsolidadoDados(idBar, categoria) {

        //     $.ajax({
        //         type: "POST",
        //         url: URL_BASE + ROTA_HOME + 'requestConsolidadoDados',
        //             data: {
        //                 'idBar': idBar,
        //                 'categoria': categoria,
        //             },
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             dataType: "json",
        //             success: function(success) {
        //                 console.log('Dados do consolidado' + success);
        //                 // return success;
        //             }
        //     });
        // }


        function getConsolidadoDados(idBar,idCategoria){

            // Validar as entradas do usuário
            idBar = parseInt(idBar) || 0;
            idCategoria = parseInt(idCategoria) || 0;

            var dados = {
                idBar:idBar,
                categoria:idCategoria,
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                type:"POST",
                url: URL_BASE + ROTA_HOME + 'requestConsolidadoDados',
                data: dados,
                dataType:"json",
                success:function(response){
                    console.log('Dados Consolidados: ', response.iconCategoria);
                },
                error:function(xhr,textStatus,errorThrown){
                    console.log('Erro na chamada ajax: ', xhr.responseText);
                }
            })


        }


        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Cervejas', 'Drinks e Doses', 'Não Alcoólicos', 'Garrafas', 'Comidinhas',
                    'Combos e Pra Levar'
                ],
                datasets: [{
                    label: 'Dezembro',
                    data: [22, 12, 3, 7, 9, 3],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }

            }
        });


        // if (statusBar == 1) {
        //     document.getElementById("abrirBar").disabled = true;
        //     $("#abrirBar").addClass("btn-secondary");
        //     $("#fecharBar").addClass("btn-danger");
        // } else {
        //     document.getElementById("fecharBar").disabled = true;
        //     $("#fecharBar").addClass("btn-secondary");
        //     $("#abrirBar").addClass("btn-success");
        // }

        //desabilita o botão no início

        // $("#abrirBar").click(function () {
        //     Swal.fire({
        //         position: 'center',
        //         icon: 'warning',
        //         title: 'Abrir bar?',
        //         html: 'Deseja realmente abrir esse bar?',
        //         allowOutsideClick: false,
        //         showCloseButton: true,
        //         showCancelButton: true,
        //         focusConfirm: false,
        //         confirmButtonText: '<i class="fa fa-thumbs-up pr-1 pl-1"></i> SIM ',
        //         cancelButtonText: '<i class="fa fa-thumbs-down pr-1 pl-1"></i> CANCELAR',
        //     }).then((result) => {
        //         if (result.isConfirmed) {

        //             document.getElementById("abrirBar").disabled = true;
        //             document.getElementById("fecharBar").disabled = false;
        //             // $( "#abrirBar" ).removeClass( "btn-success" ).addClass( "btn-secondary" );
        //             statusBarAtualizado = 1;
        //             updateStatusBar(statusBarAtualizado).then((result) => {

        //                 Swal.fire({
        //                     icon: 'success',
        //                     title: 'BAR ABERTO!',
        //                     html: 'O bar foi aberto com sucesso!',
        //                 });

        //                 location.reload();
        //             });

        //         }
        //     });


        // });

        // $('#fecharBar').click(function () {

        //     Swal.fire({
        //         position: 'center',
        //         icon: 'warning',
        //         title: 'Fechar bar?',
        //         html: 'Deseja realmente fechar esse bar?',
        //         allowOutsideClick: false,
        //         showCloseButton: true,
        //         showCancelButton: true,
        //         focusConfirm: false,
        //         confirmButtonText: '<i class="fa fa-thumbs-up pr-1 pl-1"></i> SIM ',
        //         cancelButtonText: '<i class="fa fa-thumbs-down pr-1 pl-1"></i> CANCELAR',
        //     }).then((result) => {
        //         if (result.isConfirmed) {

        //             document.getElementById("fecharBar").disabled = true;
        //             document.getElementById("abrirBar").disabled = false;

        //             statusBarAtualizado = 0;

        //             updateStatusBar(statusBarAtualizado).then((result) => {
        //                 Swal.fire({
        //                     icon: 'success',
        //                     title: 'BAR FECHADO!',
        //                     html: 'O bar foi fechado com sucesso!',
        //                 });

        //                 location.reload();

        //             });

        //         }
        //     });





        // });


        // updateStatusBar = (fieldStatus) => {
        //     return new Promise((resolve, reject) => {
        //         $.ajax({
        //             url: URL_BASE + URL_CONTROLLER,
        //             method: 'POST',
        //             data: {
        //                 'status': fieldStatus,
        //             },
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             success: function (success) {
        //                 console.log(success)
        //                 return resolve(success)
        //             },
        //             erro: function (data) {

        //                 if (data.status === 0) {
        //                     Swal.fire({
        //                         icon: 'error',
        //                         title: 'Sem conexão com internet!',
        //                         html: '<br>Contate o administrador.',
        //                     });
        //                     return reject(data)
        //                 } else if (data.status == 404 || data.status == 405) {
        //                     Swal.fire({
        //                         icon: 'error',
        //                         title: 'Página Solicitada não encontrada',
        //                         html: '<br>Contate o administrador.',
        //                     });
        //                     return reject(data)

        //                 } else if (data.status == 500) {
        //                     Swal.fire({
        //                         icon: 'error',
        //                         title: 'Erro!',
        //                         html: '<br>Contate o administrador.',
        //                     });
        //                     return reject(data)

        //                 } else {
        //                     Swal.fire({
        //                         icon: 'error',
        //                         title: 'Erro!',
        //                         html: 'Erro Crítico! <br>Contate o administrador.',
        //                     });
        //                     return reject(data)
        //                 }


        //             }

        //         });

        //     });
        // }

    });
</script>


@endsection