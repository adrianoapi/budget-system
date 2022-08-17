<table class="table table-striped table-invoice">
    <thead>
        <tr>
            <th>Excluir</th>
            <th>Item</th>
            <th>Price</th>
            <th>Qtd</th>
            <th class="tr">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0; ?>
        @foreach($quote->items as $value)
        <?php $total = $total + ($value->Product->valor - ($value->Product->valor * $quote->fator)) * $value->quantidade; ?>
        <tr>
            <td>
                @if(!$quote->close)
                <a href="javascript:void(0)" onclick="excluir({{$value->id}})" class="btn btn-danger" rel="tooltip" title="" data-original-title="Excluir">
                    <i class="icon-trash"></i>
                </a>
                @else
                <a href="javascript:void(0)" class="btn btn-default" rel="tooltip" title="" data-original-title="Excluir" disabled="disabled">
                    <i class="icon-trash"></i>
                </a>
                @endif
            </td>
            <td class="name">{{$value->Product->descricao}}</td>
            <td class="price">
                @if($quote->fator > 0)
                <s>{{$value->Product->valor}}</s> {{number_format($value->Product->valor - ($value->Product->valor * $quote->fator), 2, ".", ",")}}
                @else
                {{$value->Product->valor}}
                @endif
            </td>
            <td class="qty">{{$value->quantidade}}</td>
            <td class="total">R${{($value->Product->valor - ($value->Product->valor * $quote->fator)) * $value->quantidade}}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4"></td>
            <td class="taxes">
                <p>
                    <span class="light">Subtotal</span>
                    <span>R${{$total}}</span>
                </p>
                @if ($quote->total > 0)
                <p>
                    <span class="light">Desconto</span>
                    <span class="totalprice">
                        R${{number_format($total - $quote->total, 2, '.', ',')}}
                    </span>
                </p>
                <p>
                    <span class="light">Total</span>
                    <span class="totalprice">
                        R${{number_format($quote->total, 2, '.', ',')}}
                    </span>
                </p>
                @else
                <p>
                    <span class="light">Total</span>
                    <span class="totalprice">
                        R${{number_format($total, 2, '.', ',')}}
                    </span>
                </p>
                @endif
                
                
            </td>
        </tr>
    </tbody>
</table>