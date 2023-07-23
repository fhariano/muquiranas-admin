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
  const sortedData = data.sort((a, b) => b.total_quantity - a.total_quantity);

  const categoryNames = Array.from(new Set(data.map(item => item.category_name)));
  const productNames = Array.from(new Set(data.map(item => item.product_name)));

  // Criar matriz para armazenar as quantidades de cada produto por categoria
  const quantities = [];
  for (const category of categoryNames) {
    const categoryQuantities = [];
    for (const product of productNames) {
      const foundItem = sortedData.find(item => item.category_name === category && item.product_name === product);
      if (foundItem) {
        categoryQuantities.push(foundItem.total_quantity);
      } else {
        categoryQuantities.push(0);
      }
    }
    quantities.push(categoryQuantities);
  }

  var chartHeaderText = 'Produtos mais vendidos por categoria';
  // Configurações do gráfico
  const ctx = document.getElementById('barChart').getContext('2d');

  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: categoryNames,
      datasets: productNames.map((productName, index) => ({
        label: `${productName}: ${quantities[index][index]}`, // Concatenando o nome do produto com a quantidade
        data: quantities.map(categoryQuantities => categoryQuantities[index]),
        backgroundColor: `rgba(54, 162, 235, 0.6)`, // Cor das barras
        borderColor: `rgba(75, 192, 192, 1)`, // Cor da borda das barras
        borderWidth: 1
      }))
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            precision: 0
          }
        },
        x: {
          stacked: true
        }
      },
      plugins: {
        title: {
          display: true,
          text: chartHeaderText,
          font: {
            size: 16
          }
        },
        legend: {
          position: 'bottom'
        },
        tooltips: {
          enabled: true,
          mode: 'index',
          intersect: false,
          callbacks: {
            label: function(tooltipItem, data) {
              const datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
              return datasetLabel;
            }
          }
        }
      }
    }
  });
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