<table class="table table-striped table-invoice">
    <thead>
        <tr>
            <th>Excluir</th>
            <th>Item</th>
            <th>Price</th>
            <th>Qty</th>
            <th class="tr">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0; ?>
        @foreach($items as $value)
        <?php $total = $total + $value->Product->valor * $value->quantidade; ?>
        <tr>
            <td>
                <a href="javascript:void(0)" onclick="excluir({{$value->id}})" class="btn btn-danger" rel="tooltip" title="" data-original-title="Excluir">
                    <i class="icon-trash"></i>
                </a>
            </td>
            <td class="name">{{$value->Product->descricao}}</td>
            <td class="price">{{$value->Product->valor}}</td>
            <td class="qty">{{$value->quantidade}}</td>
            <td class="total">R${{$value->Product->valor * $value->quantidade}}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4"></td>
            <td class="taxes">
                <p>
                    <span class="light">Subtotal</span>
                    <span>R${{$total}}</span>
                </p>
                <p>
                    <span class="light">Tax({{Auth::user()->comissao}}%)</span>
                    <?php $taxa = $total * Auth::user()->comissao / 100; ?>
                    <span>R${{number_format($taxa, 2, '.', ',')}}</span>
                </p>
                <p>
                    <span class="light">Total</span>
                    <span class="totalprice">
                        R${{number_format($total + $taxa, 2, '.', ',')}}
                    </span>
                </p>
            </td>
        </tr>
    </tbody>
</table>