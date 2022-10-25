@extends('adminlte::page')

@section('content')
{{-- Início do card 1 --}}
<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Filtros</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row" id='filter'>
                    <div class="col-md-6">

                        <label for="data">Data</label>
                        <input id='data' class="form-control" onchange="filter()" type="date">
                    </div>

                    <div class="col-md-6">
                        <label for="status">Status</label>
                        <input id='status' class="form-control" onkeyup="filter()" type="text">
                    </div>
                    <div class="col-md-2 my-3">
                        <button type="button" class="btn btn-default btn-block" onclick="clean()"><i class="fas fa-eraser" style="color: red"></i> Limpar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="table-wrapper-scroll-y my-custom-scrollbar">

  <table class="table table-bordered table-striped mb-0">
    <thead>
      <tr>
        <th scope="col">CÓDIGO</th>
        <th scope="col">PRODUTO</th>
        <th scope="col">CATEGORIA</th>
        <th scope="col">ESTOOUE GALPÃO</th>
        <th scope="col">ESTOQUE LOJA</th>
        <th scope="col">PREÇO ERP</th>
        <th scope="col">SEM PROMO</th>
        <th scope="col">PROMO 1</th>
        <th scope="col">PROMO 2</th>
        <th scope="col">PROMO 3</th>
      </tr>
    </thead>
    <tbody>
      <tr>
          <?php $cont=0; foreach ($dadosEstoque as $keyEstoque => $valueEstoque ){ 
                         
                           
                                ?> 
        <th scope="row">1</th>
        <td><?=$valueEstoque->product?></td> 
        <td>Cerveja</td>
        <td><?=$valueEstoque->new_stock?></td>
        <td><?=$valueEstoque->quantity?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <?php $cont++;}?>
    </tbody>
  </table>
  <!-- if($valueEstoque->product == $valueProduto->id){
                                  dd($valueProduto->name);
                              } $x = $idade >= 18 ? "É maior de idade" : "É menor de idade"; -->
</div>

<div style="color: #8c8b8b; display: flex; justify-content: flex-end;">Versão: 1.0.0</div>
@endsection

@section('footer')
<div class="footer">
  Muquiranas Bar - <?php echo date('Y'); ?>
</div>
@endsection