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
        @foreach($items as $value)
        <?php $total = $value->Product->valor * $value->quantidade; ?>
        <tr>
            <td>
                <a href="javascript:void(0)" onclick="excluir({{$value->id}})" class="btn" rel="tooltip" title="" data-original-title="Excluir">
                    <i class="icon-trash"></i>
                </a>
            </td>
            <td class="name">{{$value->Product->descricao}}</td>
            <td class="price">{{$value->Product->valor}}</td>
            <td class="qty">{{$value->quantidade}}</td>
            <td class="total">R${{$total}}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4"></td>
            <td class="taxes">
                <p>
                    <span class="light">Subtotal</span>
                    <span>$450.00</span>
                </p>
                <p>
                    <span class="light">Tax(10%)</span>
                    <span>$45.00</span>
                </p>
                <p>
                    <span class="light">Total</span>
                    <span class="totalprice">
                        $495.00
                    </span>
                </p>
            </td>
        </tr>
    </tbody>
</table>