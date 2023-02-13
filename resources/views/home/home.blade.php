@extends('adminlte::page')

@section('content')
<div class="card card-default">

    <div class="card-body">
        <div class="row" align="center">
            <!-- <select class="selectBar-basic-single form-control bg-primary d-flex justify-content-between" style="width:100%" id="selectBar" name="selectBar"> -->
            <select class="js-selectBar-ajax form-control bg-primary d-flex justify-content-between" style="width:100%"
                id="selectBar" name="selectBar">
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

            <div class="col-12 col-sm-6 col-md-3 sr-only" id='clsCardMedia'>

            </div>
     <div class="card-body" >
     

  
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


                                    <img src="https://s3-sa-east-1.amazonaws.com/cake-app-files/public/customers/11083/products/7583007/thumb/d7e95e59-3e56-49d6-8f4c-809a597499f6.png" alt="Product 1"
                                        class="img-circle img-size-32 mr-2">
                                        STELLA ARTOIS
                                </td>
                                <td>3 <td>
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
                                    <img src="https://s3-sa-east-1.amazonaws.com/cake-app-files/public/customers/11083/products/7689807/47477094-2cea-4d34-bf7a-a0d1024ed1f4.png" alt="Product 1"
                                        class="img-circle img-size-32 mr-2">
                                        BRAHMA EXTRA WEISS
                                </td>
                                <td>2 <td>
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
                                    <img src="https://s3-sa-east-1.amazonaws.com/cake-app-files/public/customers/11083/products/7543657/aa1bf253-1bae-4272-bc1e-4486c66115bc.png" alt="Product 1"
                                        class="img-circle img-size-32 mr-2">
                                   SKOL
                                </td>
                                <td>4 <td>
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
                                    <img src="https://s3-sa-east-1.amazonaws.com/cake-app-files/public/customers/11083/products/7689812/45d81c9f-d6e7-46f4-8a9a-9b791ca3178c.png" alt="Product 1"
                                        class="img-circle img-size-32 mr-2">
                                        CERVEJA BECKS
                                    <!-- <span class="badge bg-danger">NEW</span> -->
                                </td>
                                <td>6<td>
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
                            <?= $name ?>
                            <span class="float-right text-success">
                                <?= $qtdTotalDia ?>
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

    urlBase = window.location.origin;
    var urlController = '/resultBars';
    var rotaHome = '/categorias/';
    // const statusBar = document.getElementById('statusBar').value;
    const $selectBar = $('#selectBar');
    const $selectCategories = $('#categoriesBar');
    let $idBarSelecionado = 1;
    $('#selectBar').select2();
    $('#categoriesBar').select2();


valorReceita = '250,00';
text = 'RECEITAS';

cardReceita(valorReceita, text);
    
        function cardReceita(valor,text){
            console.log(valorReceita);
         let cardReceita = '';
                cardReceita += '<div class="info-box">';
                    cardReceita += '<span class="info-box-icon  bg-success elevation-1"> <i class="fas fa-qrcode"></i> </span>';
                    cardReceita += '<div class="info-box-content">';
                        cardReceita += '<span class="info-box-text"><b> RECEITAS </b></span>';
                        cardReceita += '<span class="info-box-number">';
                        cardReceita +=  '$'+ valor ;

                        cardReceita += '</span>';
                    cardReceita += '</div>';
                cardReceita += '</div>';
                $('#clsCardReceita').append(cardReceita);

        } 

    function updateValueCardReceita(newValue) {
        $('.info-box-number').text(newValue);
        $('.info-box-text').text('RECEITA');

    } 



       

    $selectBar.change(function(event) {
        idBarSelecionado = $(this).val();
        updateValueCardReceita('170');

              $('#categoriesBar').empty();

        if (idBarSelecionado) {
            $("#categoriesBar").show();
            $.ajax({
                type: "POST",
                url: urlBase + rotaHome + 'getCategories',
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

    });


    //Fazendo

    $selectCategories.change(function(event) {
        idCategories = $(this).val();
        $( "div" ).remove( ".divBox" );

        if (idCategories) {
            $(event.target).parent("#divBoxTotalItens").remove(); 
                     
            console.log('ID categoria selecionada' + idCategories);

            let cardTotalItens = '';
            cardTotalItens += '<div class="info-box mb-3" divBox>';
            cardTotalItens +=
                '     <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-qrcode"></i></span>';
            cardTotalItens += '      <div class="info-box-content">';
            cardTotalItens += '             <span class="info-box-text"><b>ITENS</b></span>';
            cardTotalItens += '             <span class="info-box-number">';
            cardTotalItens += '                 <?= $qtdTotalDia ?>';
            cardTotalItens += '             </span>';
            cardTotalItens += '       </div>';
            cardTotalItens += '       </div>';
            cardTotalItens += '       </div>';


            let cardTotal = '';
            cardTotal += '<div class="info-box mb-3">';
            cardTotal +=
                '<span class="info-box-icon bg-info elevation-1"><i class="fas fa-qrcode"></i></span>';
            cardTotal += '<div class="info-box-content">';
            cardTotal += '<span class="info-box-text"><b>TOTAL</b></span>';
            cardTotal += '<span class="info-box-number">';
            cardTotal += '$ <?= $totalDia ?>,00';
            cardTotal += '</span>';
            cardTotal += '</div>';
            cardTotal += '</div>';

            $("#tabelaProdutos").removeClass("sr-only");

            $('#clsCardITotaltens').append(cardTotalItens);
            $("#clsCardITotaltens").removeClass("sr-only");

            $('#clsCardTotal').append(cardTotal);
            $("#clsCardTotal").removeClass("sr-only");


            $('#clsCardMedia').append(
                '<div class="info-box mb-3"><span class="info-box-icon bg-warning elevation-1"><i class="fas fa-qrcode"></i></span> <div class="info-box-content"> <span class="info-box-text"><b>MÉDIA</b></span> <span class="info-box-number">$<?= $mediaDia?> </span> </div></div> '
                )
            $("#clsCardMedia").removeClass("sr-only");


            // $.ajax({
            //     type:"POST",
            //     url: urlBase + rotaHome + 'getCategories',
            //     data: {
            //        'idBarSelecionado':idBarSelecionado,
            //     },
            //     headers: {
            //          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     },
            //     dataType:"json",
            //     success:function(categories){
            //         $("#categoriesBar").append('<option class="font-weight-bold" selected disabled value="" align="center">CATEGORIAS</option>')

            //         $.each(categories,function(key,value){
            //             $("#selectCategories").removeClass("sr-only");

            //         $("#categoriesBar").append('<option value="'+key['id'] +'">' +value['name'] +'<option>');


            //         });

            //         $("#categoriesBar").trigger("change");
            //     }
            // });

        }
    })


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
    //             url: urlBase + urlController,
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