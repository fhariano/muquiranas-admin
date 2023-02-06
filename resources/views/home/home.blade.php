@extends('adminlte::page')

@section('content')
<div class="card card-default">

    <div class="card-body">
        <div class="row" align="center">
            <!-- <select class="selectBar-basic-single form-control bg-primary d-flex justify-content-between" style="width:100%" id="selectBar" name="selectBar"> -->
            <select class="js-selectBar-ajax form-control bg-primary d-flex justify-content-between" style="width:100%" id="selectBar" name="selectBar">
                <option class="font-weight-bold" selected disabled value="" align="center">BARES</option>
                @foreach($fieldsBar as $key => $value)
                <option value="{{$value['id'] }}">{{ $value['name'] }}</option>
                @endforeach
            </select>
        </div>

         <div class="row sr-only" id="selectCategories"  align="center">
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
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <!-- <span class="info-box-icon  bg-success elevation-1"> <i class="fa fa-barcode-usd"></i> </span> -->
                    <span class="info-box-icon  bg-success elevation-1"> <i class="fas fa-qrcode"></i> </span>
                    <div class="info-box-content">
                        <span class="info-box-text"><b> TOTAL GERAL </b></span>
                        <span class="info-box-number">
                            $
                            <?= $totalGeral ?>,00

                        </span>
                    </div>

                </div>

            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-qrcode"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><b>QTD TOTAL</b></span>
                        <span class="info-box-number">
                            <?= $qtdTotalDia ?>
                        </span>
                    </div>
                </div>

            </div>


            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-qrcode"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><b>TOTAL</b></span>
                        <span class="info-box-number">
                            $
                            <?= $totalDia ?>,00
                        </span>
                    </div>

                </div>

            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-qrcode"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><b>MÉDIA</b></span>
                        <span class="info-box-number">
                            $
                            <?= $mediaDia ?>
                        </span>
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

        $selectBar.change(function(event) {
            idBarSelecionado = $(this).val();
            $('#categoriesBar').empty();

            if(idBarSelecionado){
                $("#categoriesBar").show();
                $.ajax({
                    type:"POST",
                    url: urlBase + rotaHome + 'getCategories',
                    data: {
                       'idBarSelecionado':idBarSelecionado,
                    },
                    headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType:"json",
                    success:function(categories){
                        $("#categoriesBar").append('<option class="font-weight-bold" selected disabled value="" align="center">CATEGORIAS</option>')
                        
                        $.each(categories,function(key,value){
                            $("#selectCategories").removeClass("sr-only");
                            
                        $("#categoriesBar").append('<option value="'+key['id'] +'">' +value['name'] +'<option>');
                    
                            
                        });
                        
                        $("#categoriesBar").trigger("change");
                    }
                });
            }else{
                $("categoriesBar").hide();
            }
           

        });

        //Fazendo

        selectCategories.change(function(event){
            $idCategories = $this.val();

            if(idCategories){

                $.ajax({
                    type:"POST",
                    url: urlBase + rotaHome + 'getCategories',
                    data: {
                       'idBarSelecionado':idBarSelecionado,
                    },
                    headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType:"json",
                    success:function(categories){
                        $("#categoriesBar").append('<option class="font-weight-bold" selected disabled value="" align="center">CATEGORIAS</option>')
                        
                        $.each(categories,function(key,value){
                            $("#selectCategories").removeClass("sr-only");
                            
                        $("#categoriesBar").append('<option value="'+key['id'] +'">' +value['name'] +'<option>');
                    
                            
                        });
                        
                        $("#categoriesBar").trigger("change");
                    }
                });

            }
        })


        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Cervejas', 'Drinks e Doses', 'Não Alcoólicos', 'Garrafas', 'Comidinhas', 'Combos e Pra Levar'],
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