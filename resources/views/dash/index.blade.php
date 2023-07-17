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
    var dadosGraficoVindoController = @json($dataChart);


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
            ' <div class="bs-dash float-left"> <button class="btn btn-primary d-none" id="printButton" type="button" title="Imprimir" onclick="printviewDash();">Imprimir </button> <br> <br> <h4 align="center" id="headerEstoqueBar">Estoque Atual</h4></div>'
        );
        $('.fixed-table-toolbar').prepend(header);


        $('#data-table').bootstrapTable('load', data);
        $('#data-table').removeClass('d-none');
        $('#printButton').removeClass('d-none');
        const productsWithMaxQuantity = getProductsByMaxQuantity(dadosGraficoVindoController);
        generateProductConsumptionChart(productsWithMaxQuantity);
    }


    printviewDash = () => {
        window.print();
    }




    function generateProductConsumptionChart(data) {

        const categoryNames = Array.from(new Set(data.map(item => item.category_name)));
        const productNames = Array.from(new Set(data.map(item => item.product_name)));

        // Criar matriz para armazenar as quantidades de cada produto por categoria
        const quantities = [];
        for (const category of categoryNames) {
            const categoryQuantities = [];
            for (const product of productNames) {
                const foundItem = data.find(item => item.category_name === category && item.product_name ===
                    product);
                if (foundItem) {
                    categoryQuantities.push(foundItem.total_quantity);
                } else {
                    categoryQuantities.push(0);
                }
            }
            quantities.push(categoryQuantities);
        }


        // var labels = [];
        // // var quantities = [];

        // // Extrair as categorias e quantidades dos dados
        // for (var i = 0; i < data.length; i++) {
        //     labels.push(data[i].product_name);
        //     quantities.push(data[i].total_quantity);
        // }

        function getRandomColor(alpha,index, productName) {
  const r = Math.floor(Math.random() * 256);
  const g = Math.floor(Math.random() * 256);
  const b = Math.floor(Math.random() * 256);
  return `rgba(${r}, ${g}, ${b}, ${alpha},${index / productNames.length})`;
}


        // Configurações do gráfico

        const ctx = document.getElementById('barChart').getContext('2d');
        const chart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: categoryNames,
    datasets: productNames.map((productName, index) => ({
      label: productName,
      data: quantities.map(categoryQuantities => categoryQuantities[index]),
    //   backgroundColor: `rgba(75, 192, 192, ${index / productNames.length})`, // Cor das barras
      backgroundColor: getRandomColor(1.0,index,productName.length), // Cor das barras
      borderColor: 'rgba(75, 192, 192, 1)', // Cor da borda das barras
      borderWidth: 1
    }))
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});
        // var ctx = document.getElementById('barChart').getContext('2d');
        // var chartHeaderText = 'Produtos mais vendidos por categoria';

        // var chart = new Chart(ctx, {
        //     type: 'bar',
        //     data: {
        //         labels: labels,
        //         datasets: [{
        //             label: 'Quantidade',
        //             data: quantities,
        //             backgroundColor: 'rgba(54, 162, 235, 0.6)',
        //             borderColor: 'rgba(54, 162, 235, 1)',
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         plugins: {
        //             title: {
        //                 display: true,
        //                 text: chartHeaderText,

        //             }
        //         },
        //         scales: {
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }
        //     }
        // });
    }

    function getProductsByMaxQuantity(data) {
        const productsByCategory = {};

        for (const item of data) {
            const {
                category_name,
                product_name,
                total_quantity
            } = item;

            if (!productsByCategory[category_name]) {
                productsByCategory[category_name] = {
                    category_name,
                    product_name,
                    total_quantity
                };
            } else {
                const currentQuantity = productsByCategory[category_name].total_quantity;
                if (total_quantity > currentQuantity) {
                    productsByCategory[category_name] = {
                        category_name,
                        product_name,
                        total_quantity
                    };
                }
            }
        }

        const result = Object.values(productsByCategory);
        return result;
    }


});
</script>
@endsection