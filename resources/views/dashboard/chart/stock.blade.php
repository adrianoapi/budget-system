<table class="table">
  <tr>
    <th>Quantidade</th>
    <th>Produto</th>
  </tr>
  @foreach($produtos as $produto)
    <tr>
      <td>{{$produto->quantidade}}</td>
      <td>
        {{$produto->descricao}}
        
        <?php
        $stockProds = \App\Models\Stock::where('deleted_at', NULL)
                        ->where('product_id', $produto->id)
                        ->where('inserido', false)
                        ->orderBy('dt_lancamento', 'asc')
                        ->limit(5)
                        ->get();

          foreach($stockProds as $value):
              echo "<li>Previsão de mais <strong>{$value->quantidade}</strong> produtos no estoque em <strong>{$value->dt_lancamento}</strong></li>";
          endforeach;
        ?>
      </td>
    </tr>
  @endforeach
  <tfoot>
    <tr>
      <td colspan="2">
        <a href="{{route('produtos.index')}}" class="btn brn-default">Todos</a>
      </td>
    </tr>
  </tfoot>
</table>