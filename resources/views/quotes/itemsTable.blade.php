<table class="table table-striped table-invoice">
    <thead>
        <tr>
            <th>Excluir</th>
            <th>Item</th>
            <th>Price</th>
            <th>Fator</th>
            <th>Qtd</th>
            <th class="tr" colspan="2">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $total = 0;
            $i = 0;
        ?>
        @foreach($quote->items as $value)
        <?php 
        $i++;
        if($quote->fator > 0){
            $total = $total + ($value->Product->valor * $quote->fator) * $value->quantidade;
        }else{
            $total = $total + $value->Product->valor * $value->quantidade;
        }
         ?>
        <tr>
            <td>
                @if(!$quote->close)
                <a href="javascript:void(0)" onclick="excluir({{$value->id}})" class="btn btn-danger" rel="tooltip" title="" data-original-title="Excluir">
                    <i class="icon-trash"></i>
                </a>
                <a href="javascript:void(0)" onclick="update({{$value->id}})" class="btn btn-lime" rel="tooltip" title="" data-original-title="Excluir">
                    <i class="icon-undo"></i>
                </a>
                @if($i > 1)
                <a href="javascript:void(0)" onclick="order({{$value->id}}, 'up')" class="btn btn-primary" rel="tooltip" title="" data-original-title="Excluir">
                    <i class="glyphicon-up_arrow"></i>
                </a>
                @endif
                @if($i < $quote->items->count())
                <a href="javascript:void(0)" onclick="order({{$value->id}}, 'down')" class="btn btn-primary" rel="tooltip" title="" data-original-title="Excluir">
                    <i class="glyphicon-down_arrow"></i>
                </a>
                @endif
                
                @else
                <a href="javascript:void(0)" class="btn btn-default" rel="tooltip" title="" data-original-title="Excluir" disabled="disabled">
                    <i class="icon-trash"></i>
                </a>
                @endif
            </td>
            <td class="name">{{$value->Product->descricao}}</td>
            <td class="price">
                {{$value->Product->valor}}
            </td>
            <td class="price">
                <?php $tableFator = 'table_fator_'.$value->id;?>
                <select name="{{$tableFator}}" id="{{$tableFator}}" class='input-small'>
                    @foreach($fatorLista as $key => $faValue)
                        <option value="{{$key}}" {{$faValue == $value->fator ? "selected" : NULL}}>{{$faValue}}</option>
                    @endforeach
                </select>
            </td>
            <td class="price">
                @if($value->fator > 0)
                 {{$value->Product->valor * $value->fator}}
                @else
                 {{$value->Product->valor}}
                @endif
            </td>
            <td class="qty">
                <?php $tableQtd = 'table_quantidade_'.$value->id;?>
                {{Form::number($tableQtd, $value->quantidade,
                [
                    'id' => $tableQtd,
                    'placeholder' => '1',
                    'class' => 'input-small',
                    'required' => true,
                    'min' => 1,
                    'disabled' => $quote->close > 0 ? true : false
                    ])}}
                </td>
            <td class="total">
                @if($quote->fator > 0)
                R${{($value->Product->valor * $quote->fator) * $value->quantidade}}
                @else
                R${{$value->Product->valor * $value->quantidade}}
                @endif
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="6"></td>
            <td class="taxes">
                <p>
                    <span class="light">Subtotal</span>
                    <span>R${{$total}}</span>
                </p>
  

                @if ($quote->percentual > 0)
                <p>
                    <span class="light">-{{$quote->percentual}}%</span>
                    <span class="totalprice">
                        <?php
                            $descontoPerccentual = ($total * $quote->percentual / 100);
                            $total = $total - $descontoPerccentual;
                        ?>
                        R${{number_format($descontoPerccentual, 2, '.', ',')}}
                    </span>
                </p>
                @endif

                @if ($quote->total > 0)
                <p>
                    <span class="light">Desconto</span>
                    <span class="totalprice">
                        <?php $total = $total - $quote->total; ?>
                        R${{number_format($total, 2, '.', ',')}}
                    </span>
                </p>
                @endif

                @if ($quote->total > 0)
                <p>
                    <span class="light">Total</span>
                    <span class="totalprice">
                        R${{$quote->total, 2, '.', ','}}
                    </span>
                </p>
                @else
                <p>
                    <span class="light">Total</span>
                    <span class="totalprice">
                        R${{$total, 2, '.', ','}}
                    </span>
                </p>
                @endif
                
                
            </td>
        </tr>
    </tbody>
</table>