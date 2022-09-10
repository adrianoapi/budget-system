@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid" id="content">

    @include('layouts.navigation')

    <div id="main">
        <div class="container-fluid">

        <div class="row-fluid">

            <div class="span12">
                <div class="box box-bordered box-color">
                    <div class="box-title">
                        <h3>
                            <i class="icon-reorder"></i>
                            Cotação
                            @if($quote->close)
                            FECHADA
                            @endif
                        </h3>
                    </div>
                    <div class="box-content nopadding">
                        <div class="tabs-container">
                            <ul class="tabs tabs-inline tabs-top">
                                <li class='active'>
                                    <a href="#first11" data-toggle='tab'><i class="icon-list-alt"></i> Resumo</a>
                                </li>
                                <li>
                                    <a href="#second22" data-toggle='tab'><i class="icon-edit"></i> Editar</a>
                                </li>
                                <li>
                                    <a href="#third" data-toggle='tab'><i class="glyphicon-flag"></i> Fator</a>
                                </li>
                                <li>
                                    <a href="#forth" data-toggle='tab'><i class="icon-fire"></i> ICMS</a>
                                </li>
                                <li>
                                    <a href="#five" data-toggle='tab'><i class="icon-fire"></i> IPI</a>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="tab-content padding tab-content-inline tab-content-bottom">
                            
                            <div class="tab-pane active" id="first11">
                                <div class="invoice-info">
        
                                    @if(session('quote_close'))
                                        <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            {!!session('quote_close')!!}
                                        </div>
                                    @endif
        
                                    <div class="invoice-from">
                                        <span>De</span>
                                        <strong>{{$quote->company->name}}</strong>
                                        <address>
                                            {{$quote->company->endereco}}, {{$quote->company->numero}}, {{$quote->company->complemento}}<br>
                                            {{$quote->company->bairro}}, {{$quote->company->cidade}} - {{$quote->company->estado}},  {{$quote->company->cep}} <br>
                                            <abbr title="Telefone">Telefone:</abbr> {{$quote->company->telefone}} -
                                            <abbr title="Comercial">Comercial:</abbr> {{$quote->company->telefone_com}} <br>
                                            <abbr title="Celular">Celular:</abbr> {{$quote->company->celular}}
                                        </address>
                                    </div>
                                    <div class="invoice-to">
                                        <span>Para</span>
                                        <strong>{{$quote->client->name}}</strong>
                                        <address>
                                            {{$quote->client->endereco}}, {{$quote->client->numero}} <br>
                                            {{$quote->client->bairro}}, {{$quote->client->cidade}}/{{$quote->client->estado}}, {{$quote->client->cep}} <br>
                                            <abbr title="Telefone">Phone:</abbr>
                                            @if(!empty($quote->client->telefone))
                                            {{$quote->client->telefone}} |
                                            @endif
                                            @if(!empty($quote->client->telefone_com))
                                                {{$quote->client->telefone_com}} |
                                            @endif
                                            @if(!empty($quote->client->celular))
                                                {{$quote->client->celular}}
                                            @endif<br>
                                            <abbr title="E-mail">E-mail:</abbr> {{$quote->client->celular}}
                                        </address>
                                    </div>
                                    <div class="invoice-infos">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <th>Serial #:</th>
                                                    <td>
                                                        {{$quote->serial}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="basic-margin">
                                            Nome do Projeto: <strong>{{$quote->name}}</strong>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="basic-margin" style="float:right;">
                                            @if(!$quote->close)
                                            <a href="#new-task" data-toggle="modal" class="btn btn-primary"><i class="icon-plus-sign"></i> Adicionar Produto</a>
                                            @else
                                            <a href="javascript:void(0)" class="btn btn-default" disabled="disabled"><i class="icon-plus-sign"></i> Adicionar Produto</a>
                                            <a href="{{route('cotacoes.export', $quote->id)}}" class="btn btn-lightred" style=""><i class="icon-file-alt"></i> Exportar PDF</a>
                                                @if(!$quote->aprovado)
                                                    <a href="{{route('cotacoes.approve', $quote->id)}}" class="btn btn-satgreen" style=""  onclick="return confirm('Deseja aprovar este orçamento?')"><i class="glyphicon-unchecked"></i> Aprovar</a>
                                                @else
                                                    <a href="{{ Auth::user()->level > 1 ? route('cotacoes.approve', $quote->id) : 'javascript:void(0)'}}" class="btn btn-satgreen" {{ Auth::user()->level > 1 ? '': 'disabled'}}><i class="glyphicon-check"></i> Aprovado</a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="dinamic-table">Carregando...</div>
                                @if(!$quote->close)
                                <div class="invoice-payment">
                                    {{ Form::open(['route' => ['cotacoes.close', $quote->id],  'method' => 'POST']) }}
                                    {!! Form::button('<i class="icon-folder-close-alt"></i> Fechar Cotação', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                                    {{ Form::close() }}
                                </div>
                                @else 
                                <div class="invoice-payment">
                                    {{ Form::open(['route' => ['cotacoes.clone', $quote->id],  'method' => 'POST']) }}
                                    {!! Form::button('<i class="icon-copy"></i> Clonar Cotação', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
                                    {{ Form::close() }}
                                </div>
                                @endif

                                @if($quote->close)
                                <!--Form comercail begin-->
                                <div class="row-fluid">
                                    <div class="box box-bordered">
                                        <div class="box-title">
                                            <h3><i class="icon-th-list"></i> Condições comerciais</h3>
                                        </div>
                                        <div class="box-content nopadding">
                                            {{ Form::open(['route' => ['cotacoes.update.comercial', $quote->id],  'method' => 'POST', 'class' =>'form-horizontal form-bordered']) }}
                                                @method('PUT')
                                                <div class="control-group">
                                                    <label for="representante" class="control-label">Representante</label>
                                                    <div class="controls">
                                                        <input type="text" name="representante" id="representante" value="{{!empty($quote->representante) ? $quote->representante : 'usuario' }}" placeholder="representante..." class="input-xlarge">
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="pagamento" class="control-label">Pagamento</label>
                                                    <div class="controls">
                                                        <input type="text" name="pagamento" id="pagamento" value="{{$quote->pagamento}}" placeholder="pagamento..." class="input-xlarge">
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="prazo" class="control-label">Prazo</label>
                                                    <div class="controls">
                                                        <input type="text" name="prazo" id="prazo" value="{{$quote->prazo}}" placeholder="prazo..." class="input-xlarge">
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="transportadora" class="control-label">Transportadora</label>
                                                    <div class="controls">
                                                        <input type="text" name="transportadora" id="transportadora" value="{{$quote->transportadora}}" placeholder="transportadora..." class="input-xlarge">
                                                    </div>
                                                </div>
                                                <div class="form-actions">
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                    <button type="button" class="btn">Cancel</button>
                                                </div>
                                            {{ Form::close() }}
                                        </div>
                                    </div>
                                </div>
                                <!--Form comercail end-->
                                @endif
                            
                            </div><!--tab 1-->

                            <div class="tab-pane" id="second22">
                                {{ Form::open(['route' => ['cotacoes.update', $quote->id], 'class' => 'form-vertical']) }}    
                                    @csrf 
                                    @method('PUT')
    
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <div class="control-group">
                                                <label for="name" class="control-label">Nome do Projeto</label>
                                                <div class="controls">
                                                    <input type="text" name="name" id="name" value="{{$quote->name}}" placeholder="Insira um nome" class="input-block-level">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="control-group">
                                                <label for="multa" class="control-label">Empesa</label>
                                                <div class="controls controls-row">
                                                    <select name="company_id" id="company_id" class='input-block-level'>
                                                        <option value="">Empesa</option>
                                                        @foreach($companies as $value)
                                                            <option value="{{$value->id}}" {{$quote->company_id == $value->id ? "selected" : NULL}}>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label for="multa" class="control-label">Cliente</label>
                                                <div class="controls controls-row">
                                                    <select name="client_id" id="client_id" class='input-block-level'>
                                                        <option value="">Cliente</option>
                                                        @foreach($clients as $value)
                                                            <option value="{{$value->id}}" {{$quote->client_id == $value->id ? "selected" : NULL}}>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                {{Form::label('total', 'Total (0,00)', array('class' => 'control-label'))}}
                                                <div class="controls">
                                                    <div class="input-append">
                                                        <span class="add-on">R$</span>
                                                        {{Form::text('total', $quote->total, [
                                                            'id' => 'total',
                                                            'placeholder' => '0.00', 
                                                            'class' => 'money input-medium', 
                                                            'required' => true,
                                                            'disabled' => $quote->close > 0 ? true : false
                                                            ]
                                                            )}}
                                                        @error('total')
                                                        <div class="alert-danger input-xlarge">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="control-group">
                                                <label for="multa" class="control-label">Aprovado</label>
                                                <div class="controls controls-row">
                                                    <select name="aprovado" id="aprovado" class='input-block-level'>
                                                        <option value="1" {{$quote->aprovado == true ? "selected" : NULL}}>Sim</option>
                                                        <option value="0" {{$quote->aprovado != true ? "selected" : NULL}}>Não</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                {{Form::label('percentual', 'Desconto Percentual (0,00)', array('class' => 'control-label'))}}
                                                <div class="controls">
                                                    <div class="input-append">
                                                        <span class="add-on">%</span>
                                                        {{Form::text('percentual', $quote->percentual, [
                                                            'id' => 'percentual',
                                                            'placeholder' => '0.00', 
                                                            'class' => 'money input-medium', 
                                                            'required' => true,
                                                            'disabled' => $quote->close > 0 ? true : false
                                                            ]
                                                            )}}
                                                        @error('percentual')
                                                        <div class="alert-danger input-xlarge">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                {{Form::label('frete', 'Frete (0,00)', array('class' => 'control-label'))}}
                                                <div class="controls">
                                                    <div class="input-append">
                                                        <span class="add-on">R$</span>
                                                        {{Form::text('frete', $quote->frete, [
                                                            'id' => 'frete',
                                                            'placeholder' => '0.00', 
                                                            'class' => 'money input-medium', 
                                                            'required' => true,
                                                            'disabled' => $quote->close > 0 ? true : false
                                                            ]
                                                            )}}
                                                        @error('frete')
                                                        <div class="alert-danger input-xlarge">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="row-fluid">
                                        <div class="form-actions">
                                            {{Form::button('Salvar', [
                                                    'type' => 'submit',
                                                    'class'=> 'btn btn-primary',
                                                    'disabled' => $quote->close > 0 ? true : false
                                            ])}}
                                        </div>
                                    </div>
                                </form>
                            </div><!--Tab 2-->
                            <div class="tab-pane" id="third">
                                {{ Form::open(['route' => ['cotacoes.update.fator', $quote->id], 'class' => 'form']) }}    
                                    @csrf 
                                    @method('PUT')
    
                                    <div class="row-fluid">
                                        <div class="span2">
                                            <div class="control-group">
                                                {{Form::label('fator', 'Fator', array('class' => 'control-label'))}}
                                                <div class="controls">
                                                    {{Form::text('fator', $quote->fator,
                                                    [
                                                        'id' => 'fator',
                                                        'class' => 'fator input-small',
                                                        'style' => 'margin-bottom:0',
                                                        'disabled' => $quote->close > 0 ? true : false
                                                    ])}}
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
    
                                    <div class="row-fluid">
                                        <div class="form-actions">
                                            {{Form::button('Salvar', [
                                                    'type' => 'submit',
                                                    'class'=> 'btn btn-primary',
                                                    'disabled' => $quote->close > 0 ? true : false
                                            ])}}
                                        </div>
                                    </div>
                                </form>
                            </div><!--Tab 3-->
                            <div class="tab-pane" id="forth">
                                {{ Form::open(['route' => ['cotacoes.update.icms', $quote->id], 'class' => 'form']) }}    
                                    @csrf 
                                    @method('PUT')
    
                                    <div class="row-fluid">
                                        <div class="span2">
                                            <div class="control-group">
                                                {{Form::label('icms', 'ICMS', array('class' => 'control-label'))}}
                                                <div class="controls">
                                                    <select name="icms" id="icms" class='input-small'>
                                                        @foreach($icmsLista as $keyIcms => $icmsValue)
                                                            <option value="{{$keyIcms}}" {{$keyIcms == $quote->icms ? "selected" : NULL}}>{{$icmsValue}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
    
                                    <div class="row-fluid">
                                        <div class="form-actions">
                                            {{Form::button('Salvar', [
                                                    'type' => 'submit',
                                                    'class'=> 'btn btn-primary',
                                                    'disabled' => $quote->close > 0 ? true : false
                                            ])}}
                                        </div>
                                    </div>
                                </form>
                            </div><!--Tab 4-->
                            <div class="tab-pane" id="five">
                                {{ Form::open(['route' => ['cotacoes.update.ipi', $quote->id], 'class' => 'form']) }}    
                                    @csrf 
                                    @method('PUT')
    
                                    <div class="row-fluid">
                                        <div class="span2">
                                            <div class="control-group">
                                                {{Form::label('ipi', 'IPI', array('class' => 'control-label'))}}
                                                <div class="controls">
                                                    <select name="ipi" id="ipi" class='input-small'>
                                                        @foreach($ipiLista as $keyIpi => $valueIpi)
                                                            <option value="{{$keyIpi}}" {{$keyIpi == $quote->ipi ? "selected" : NULL}}>{{$valueIpi}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
    
                                    <div class="row-fluid">
                                        <div class="form-actions">
                                            {{Form::button('Salvar', [
                                                    'type' => 'submit',
                                                    'class'=> 'btn btn-primary',
                                                    'disabled' => $quote->close > 0 ? true : false
                                            ])}}
                                        </div>
                                    </div>
                                </form>
                            </div><!--Tab 5-->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal-->
        <div id="new-task" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Adicionando Produto</h3>
            </div>
            <form action="#" onsubmit="return false;" name="addItem" id="addItem" class='new-task-form form-horizontal form-bordered'>
                <div class="">
                    <div class="control-group">
                        {{Form::label('codigo', 'Código*', array('class' => 'control-label'))}}
                        <div class="controls">
                            <div class="input-xlarge">
                                <select name="produto" id="select-product" onselect="showDynamic(this.id)" class='chosen-select' required="true">
                                    <option value="">Selecione...</option>
                                    @foreach($products as $value)
                                    <option value="{{$value->id}}">{{$value->codigo}} - {{$value->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('espessura', 'Quantidade', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('quantidade', '', ['id' => 'quantidade','placeholder' => '0', 'class' => 'input-medium', 'required' => true])}}
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('espessura', 'Espessura', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('espessura', '', ['id' => 'espessura','placeholder' => '0', 'class' => 'input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('cobre', 'Cobre', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('cobre', '', ['id' => 'cobre','placeholder' => '0', 'class' => 'input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('aco', 'Aço', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('aco', '', ['id' => 'aco','placeholder' => '0', 'class' => 'input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('valor', 'Valor', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('valor', '', ['id' => 'valor','placeholder' => '0.00', 'class' => 'money input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('linha', 'Linha', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('linha', '', ['id' => 'linha','placeholder' => '...', 'class' => 'input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Adicionar">
                </div>
            </form>
    
        </div>
                    

        </div>
    </div>

</div>

<script type="text/javascript">

function notification(color, content)
{
    new jBox('Notice', {
        animation: 'flip',
        color: color,
        content: content,
        delayOnHover: true,
        showCountdown: true
    });
}

(function( $ ) {
    $(function() {
        $('.money').mask('#.##0,00', {reverse: true});
        $('.fator').mask('#.##', {reverse: true});
    });
})(jQuery);


const attributes = ['espessura', 'cobre', 'aco', 'valor', 'icms', 'ipi'];

$('#select-product').on('change', function () {
  //console.log('Changed option value ' + this.value);
  //console.log('Changed option text ' + $(this).find('option').filter(':selected').text());
  clear();

  $.ajax({
    url: "{{route('produtos.show')}}",
    type: "GET",
    data: {
        "_token": "{{csrf_token()}}",
        "id": this.value
    },
    dataType: 'json',
        success: function(data)
        {
            console.log(data);
            for(var i = 0; i < attributes.length; i++)
            {
                $("#"+attributes[i]).val(data[attributes[i]]);
            }
        }
    });
});

function clear()
{
    for(var i = 0; i < attributes.length; i++)
    {
        $("#"+attributes[i]).val("");
    }
}

$("#addItem").submit(function() {
    const obj = {
        produto: $("#select-product").val(),
        quantidade: $("#quantidade").val(),
        cotacao: {{$quote->id}}
    };

    $.ajax({
        url: "{{route('itens.store')}}",
        type: "POST",
        cache: false,
        datatype: "JSON",
        data: {
            "_token": "{{csrf_token()}}",
            "data": JSON.stringify(obj)
        },
        dataType: 'json',
        success: function(data)
        {
            getTable("green", "Produto adicionado!");
        }
    });
});

$("#tb-cotacao").on("click", "#delete", function() {
   $(this).closest("tr").remove();
});

function excluir(id) {

    $.ajax({
        url: "{{route('itens.destroy')}}",
        type: "POST",
        cache: false,
        datatype: "JSON",
        data: {
            "_token": "{{csrf_token()}}",
            "id": id
        },
        dataType: 'json',
        success: function(data)
        {
            getTable("green", "Produto excluído!");
        }
    });
}

function update(id) {

    $.ajax({
        url: "{{route('itens.update')}}",
        type: "POST",
        cache: false,
        datatype: "JSON",
        data: {
            "_token": "{{csrf_token()}}",
            "quantidade": $("#table_quantidade_"+id).val(),
            "fator": $("#table_fator_"+id).val(),
            "icms": $("#table_icms_"+id).val(),
            "ipi": $("#table_ipi_"+id).val(),
            "id": id
        },
        dataType: 'json',
        success: function(data)
        {
            getTable("green", "Produto atualizado!");
        }
    });
}

function order(id, ordem) {

    $.ajax({
        url: "{{route('itens.order')}}",
        type: "POST",
        cache: false,
        datatype: "JSON",
        data: {
            "_token": "{{csrf_token()}}",
            "ordem": ordem,
            "id": id
        },
        dataType: 'json',
        success: function(data)
        {
            getTable("","");
        }
    });
}

function getTable(color, message)
{
    $.ajax({
    url: "{{route('cotacoes.items', $quote->id)}}",
    type: "GET",
    data: {
        "_token": "{{csrf_token()}}",
    },
    dataType: 'json',
        success: function(data)
        {
            $("#dinamic-table").html(data['table']);
            if(message != '')
            {
                notification(color, message);
            }
        }
    });
}

getTable("", "");
</script>

    
@endsection
