<table id="tb-cotacao" class="table table-striped table-hover table-invoice">
    <thead>
        <tr>
            <th>Ações</th>
            <th>Item</th>
            <th>Preço</th>
            <th>Fator</th>
            <th>Valor</th>
            <th>Qtd</th>
            <th>Cx</th>
            <th>Uni</th>
            <th>ICMS</th>
            <th>IPI</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $total = 0;
            $ipi = 0;
            $i = 0;
            $caixa_total = 0;
        ?>
        @foreach($quote->items as $value)
        <?php 
        $i++;

        # Se tiver fator > 0
        if($value->fator > 0){
            $total_produto = ($value->Product->valor * $value->fator) * $value->quantidade;
            $total = $total + $total_produto;
        }else{
            $total_produto = $value->Product->valor * $value->quantidade;
            $total = $total + $total_produto;
        }

        if($value->ipi == "7.5")
        {
            $percentual_total_produto = $total_produto;

            if($quote->percentual > 0)
            {
                $descontoPercentual       = ($total_produto * $quote->percentual / 100);
                $percentual_total_produto = $total_produto - $descontoPercentual;
            }
            $ipi = $ipi + (($percentual_total_produto * 7.5) / 100);
        }

        $caixa_produto = $value->Product->caixa > 0 ? $value->quantidade/$value->Product->caixa : 0;
        $caixa_total   += $caixa_produto; 
         ?>
        <tr>
            <td>
                @if(!$quote->close)
                <a href="javascript:void(0)" onclick="excluir({{$value->id}})" class="btn btn-danger" rel="tooltip" id="delete" title="" data-original-title="Excluir">
                    <i class="icon-trash"></i>
                </a>
                <a href="javascript:void(0)" onclick="update({{$value->id}})" class="btn btn-lime" rel="tooltip" title="" data-original-title="Excluir">
                    <i class="icon-undo"></i>
                </a>
                @if($i > 1)
                <a href="javascript:void(0)" onclick="order({{$value->id}}, 'up')" class="btn btn-default" rel="tooltip" title="" data-original-title="Excluir">
                    <i class="glyphicon-up_arrow"></i>
                </a>
                @else
                <a href="javascript:void(0)" class="btn btn-default" disabled rel="tooltip" title="" data-original-title="Excluir">
                    <i class="glyphicon-up_arrow"></i>
                </a>
                @endif
                @if($i < $quote->items->count())
                <a href="javascript:void(0)" onclick="order({{$value->id}}, 'down')" class="btn btn-default" rel="tooltip" title="" data-original-title="Excluir">
                    <i class="glyphicon-down_arrow"></i>
                </a>
                @else
                <a href="javascript:void(0)" class="btn btn-default" disabled rel="tooltip" title="" data-original-title="Excluir">
                    <i class="glyphicon-down_arrow"></i>
                </a>
                @endif
                
                @else
                <a href="javascript:void(0)" class="btn btn-default" rel="tooltip" title="" data-original-title="Excluir" disabled="disabled">
                    <i class="icon-trash"></i>
                </a>
                @endif
            </td>
            <td class="">{{$value->Product->descricao}}</td>
            <td class="">
                R${{number_format($value->Product->valor, 2, ",",".")}}
            </td>
            <td class="">
                <?php $tableFator = 'table_fator_'.$value->id;?>
                {{Form::text($tableFator, $value->fator,
                [
                    'id' => $tableFator,
                    'class' => 'fator input-small',
                    'style' => 'margin-bottom:0',
                    'disabled' => $quote->close > 0 ? true : false
                    ])}}
            </td>
            <td class="">
                @if($value->fator > 0)
                R${{number_format($value->Product->valor * $value->fator, 2, ",",".")}}
                @else
                R${{number_format($value->Product->valor, 2, ",",".")}}
                @endif
            </td>
            <td class="">
                <?php $tableQtd = 'table_quantidade_'.$value->id;?>
                {{Form::number($tableQtd, $value->quantidade,
                [
                    'id' => $tableQtd,
                    'placeholder' => '1',
                    'class' => 'input-small',
                    'style' => 'margin-bottom:0',
                    'required' => true,
                    'min' => 1,
                    'disabled' => $quote->close > 0 ? true : false
                    ])}}
            </td>
            <td><span title="{{$value->quantidade}}/{{$value->Product->caixa;}}">{{number_format($caixa_produto, 2, ".", ",")}}</span></td>
            <td>{{$value->Product->unidade}}</td>
            <td class="price">
                <?php $tableIcms = 'table_icms_'.$value->id;?>
                <select name="{{$tableIcms}}" id="{{$tableIcms}}" class='input-small' style="margin-bottom:0" {{$quote->close > 0 ? 'disabled' : ''}}>
                    @foreach($icmsLista as $keyIcms => $valueIcms)
                        <option value="{{$keyIcms}}" {{$keyIcms == $value->icms ? "selected" : NULL}}>{{$valueIcms}}</option>
                    @endforeach
                </select>
            </td>
            <td class="price">
                <?php $tableIpi = 'table_ipi_'.$value->id;?>
                <select name="{{$tableIpi}}" id="{{$tableIpi}}" class='input-small' style="margin-bottom:0" {{$quote->close > 0 ? 'disabled' : ''}}>
                    @foreach($ipiLista as $keyIpi => $valueIpi)
                        <option value="{{$keyIpi}}" {{$keyIpi == $value->ipi ? "selected" : NULL}}>{{$valueIpi}}</option>
                    @endforeach
                </select>
            </td>
            <td class="total">
                @if($value->fator > 0)
                R$ {{number_format(($value->Product->valor * $value->fator) * $value->quantidade, 2, ",",".")}}
                @else
                R$ {{number_format($value->Product->valor * $value->quantidade, 2, ",",".")}}
                @endif
            </td>
        </tr>
        @endforeach
        <tr>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td align="right" colspan="2" class="taxes">
                Total caixas <strong>{{number_format($caixa_total, 2, ".", ",")}}<strong>
            </td>
            <td colspan="3" class="taxes">
                <p>
                    <span class="light">Subtotal</span>
                    <span>R$ {{number_format($total, 2, ",",".")}}</span>
                </p>

                @if ($quote->percentual > 0)
                <p>
                    <span class="light">-{{$quote->percentual}}%</span>
                    <span class="totalprice">
                        <?php
                            $descontoPerccentual = ($total * $quote->percentual / 100);
                            $total = $total - $descontoPerccentual;
                        ?>
                        R$ {{number_format($descontoPerccentual, 2, ",",".")}}
                    </span>
                </p>
                @endif
  
                @if ($ipi > 0)
                <p>
                    <span class="light">7.5%</span>
                    <span class="totalprice">
                        {{number_format($ipi, 2, ",",".")}}
                    </span>
                </p>
                @endif

                @if ($quote->total > 0)
                <p>
                    <span class="light">Desconto</span>
                    <span class="totalprice">
                        <?php $total = ($total + $quote->frete + $ipi) - $quote->total; ?>
                        R${{number_format($total, 2, ",",".")}}
                    </span>
                </p>
                @endif

                @if ($quote->frete > 0)
                <p>
                    <span class="light">Frete</span>
                    <span class="totalprice">
                        R$ {{number_format($quote->frete, 2, ",",".")}}
                    </span>
                </p>
                @endif

                @if ($quote->total > 0)
                <p>
                    <span class="light">Total</span>
                    <span class="totalprice">
                        <?php 
                            $total = $quote->total;

                            if($quote->frete > 0){
                                $total = $total + $quote->frete;
                            }

                            if($ipi > 0){
                                $total = $total + $ipi;
                            }
                        ?>
                        R$ {{number_format($quote->total, 2, ",",".")}}
                    </span>
                </p>
                @else
                <p>
                    <span class="light">Total</span>
                    <span class="totalprice">
                        <?php 
                            if($quote->frete > 0){
                                $total = $total + $quote->frete;
                            }

                            if($ipi > 0){
                                $total = $total + $ipi;
                            }
                        ?>
                        R$ {{number_format($total, 2, ",",".")}}
                    </span>
                </p>
                @endif
                
                
            </td>
        </tr>
    </tbody>
</table>

<?php
if(!$quote->close){
    $quote->total_report = ($quote->total > 0) ? $quote->total : str_replace(",", "", number_format($total, 2, ".",","));
    $quote->save();
}

?>