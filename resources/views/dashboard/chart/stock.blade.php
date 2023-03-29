<table class="table">
  @foreach($produtos as $produto)
    <tr>
      <td>{{$produto->quantidade}}</td>
      <td>{{$produto->descricao}}</td>
    </tr>
  @endforeach
</table>