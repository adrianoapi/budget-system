<meta charset='utf-8'>

<table>
    <tr>
        <th>ID</th>
        <th>Códgio</th>
        <th>Descrição</th>
        <th>Quantidade</th>
    </tr>
    @foreach($products as $value)
    <tr>
        <td>{{$value->id}}</td>
        <td>{{$value->codigo}}</td>
        <td>{{$value->descricao}}</td>
        <td>{{$value->quantidade}}</td>
    </tr>
    @endforeach
</table>