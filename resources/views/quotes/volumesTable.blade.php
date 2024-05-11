<?php
    
    $peso = 0;
    $peso_total  = 0;

    $volume = 0;
    $volume_total = 0;
    $volume_total_fatura = 0;

    $modelVolume = new \App\Models\Volume();

    ?>
<table class="table table-striped table-hover table-invoice">
    <thead>
        <tr>
            <th>Ação</th>
            <th class="span-5"></th>
            <th class="span-1">Volume</th>
            <th class="span-1" colspan="3">Dimensions ( CM )</th>
            <th class="span-1">Volume M3</th>
            <th class="span-1">Volume Total  M3</th>
            <th class="span-2" colspan="2">PESO KG</th>
        </tr>
    </thead>
    @foreach($quote->volumes as $value)
    <?php
    
    $peso = $value->volume * $modelVolume->pesoFixo;
    $peso_total += $peso;

    $volume = ($value->dimensao_a * $value->dimensao_b * $value->dimensao_c) / 1000000;
    $volume_total = $volume * $value->volume;

    $volume_total_fatura += $volume_total;

    ?>
    <tr>
        <td>
            <a href="javascript:void(0)" onclick="updateVolume({{$value->id}})" class="btn btn-lime" rel="tooltip" title="" data-original-title="Atualizar">
                <i class="icon-undo"></i>
            </a>
        </td>
        <td>{{$value->nome}}</td>
        <td>
        <?php $tableQtd = 'table_volume_'.$value->id;?>
                {{Form::number($tableQtd, $value->volume,
                [
                    'id' => $tableQtd,
                    'placeholder' => '1',
                    'class' => 'input-small',
                    'style' => 'margin-bottom:0',
                    'required' => true,
                    'min' => 1
                ])}}
        </td>
        <td>
        <?php $tableQtd = 'table_dimensao_a_'.$value->id;?>
                {{Form::number($tableQtd, $value->dimensao_a,
                [
                    'id' => $tableQtd,
                    'placeholder' => '1',
                    'class' => 'input-small',
                    'style' => 'margin-bottom:0',
                    'required' => true,
                    'min' => 1,
                    'disabled' => $value->edit_dimensao_a > 0 ? false : true
                ])}}
        </td>
        <td>
        <?php $tableQtd = 'table_dimensao_b_'.$value->id;?>
                {{Form::number($tableQtd, $value->dimensao_b,
                [
                    'id' => $tableQtd,
                    'placeholder' => '1',
                    'class' => 'input-small',
                    'style' => 'margin-bottom:0',
                    'required' => true,
                    'min' => 1,
                    'disabled' => $value->edit_dimensao_b > 0 ? false : true
                ])}}
        </td>
        <td>
        <?php $tableQtd = 'table_dimensao_c_'.$value->id;?>
                {{Form::number($tableQtd, $value->dimensao_c,
                [
                    'id' => $tableQtd,
                    'placeholder' => '1',
                    'class' => 'input-small',
                    'style' => 'margin-bottom:0',
                    'required' => true,
                    'min' => 1,
                    'disabled' => $value->edit_dimensao_c > 0 ? false : true
                ])}}
        </td>
        <td>
            <?php $tableQtd = 'table_volume_m3_'.$value->id;?>
                    {{$volume}}
            </td>
        <td>
            <?php $tableQtd = 'table_volume_m3_'.$value->id;?>
                    {{$volume_total}}
            </td>
        </td>
        <td colspan="2"><?php echo $peso; ?></td>
    </tr>
    @endforeach
    
    <tfoot>
        <tr>
            <td>Total</td>
            <td colspan="6"></td>
            <td><strong>{{$volume_total_fatura}}</strong></td>
            <td  colspan="2"><strong><?php echo $peso_total; ?></strong></td>
        </tr>
    </tfoot>
    
</table>