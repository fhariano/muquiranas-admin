@extends('adminlte::page')

@section('content')

<div class="card card-default">



    <div class="card-header">
        <h1 align="center"> <b> Dashboard </b></h1>
    </div>


    <div class="container-fluid">
        <table id="data-table" class="table d-none" data-toggle="table" data-pagination="true" data-search="true">
            <thead>
                <tr>
                    <th data-field="category_name">Categoria</th>
                    <th data-field="product_name">Produto</th>
                    <th data-field="total_quantity">Quantidade</th>
                </tr>
            </thead>
        </table>
    </div>

   

            <div class="chart-container mt-4">
                <canvas id="barChart"></canvas>
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

    var urlBase = window.location.origin;
    var urlControllerDashboard = '/dash/';



    fetchDataEstoqueFinal().then(function(response) {

        fillDataTableEstoqueFinal(response);

    }).catch(function(error) {
        console.log(error);
    });



    function fetchDataEstoqueFinal() {

        return new Promise(function(resolve, reject) {
            $.ajax({
                url: urlBase + urlControllerDashboard + 'getdataEstoqueFinal',
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    resolve(response);
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
            });
        });
    }

    function fillDataTableEstoqueFinal(data) {
        var header = $(
            ' <div class="bs-dash float-left"> <button class="btn btn-primary d-none" id="printButton" type="button" title="Imprimir" onclick="printviewDash();">Imprimir </button> <br> <br> <h4 align="center" id="headerEstoqueBar">Estoque</h4></div>'
        );
        $('.fixed-table-toolbar').prepend(header);


        $('#data-table').bootstrapTable('load', data);
        $('#data-table').removeClass('d-none');
        $('#printButton').removeClass('d-none');

        generateChart(data);
    }

    $('#printButton').on('click', function() {
        window.print();
    });

    printviewDash = () => {
        window.print();
    }




    function generateChart(data) {
        var labels = [];
        var quantities = [];

        // Extrair as categorias e quantidades dos dados
        for (var i = 0; i < data.length; i++) {
            labels.push(data[i].category_name);
            quantities.push(data[i].total_quantity);
        }

        // Configurações do gráfico
        var ctx = document.getElementById('barChart').getContext('2d');
        var chartHeaderText = 'Produtos mais vendidos por categoria';

        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Quantidade',
                    data: quantities,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: chartHeaderText,
                        fontSize: 18
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }


});
</script>
@endsection