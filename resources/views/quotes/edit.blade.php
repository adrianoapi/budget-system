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
                        <ul class="tabs tabs-inline tabs-top">
                            <li class='active'>
                                <a href="#first11" data-toggle='tab'><i class="icon-list-alt"></i> Resumo</a>
                            </li>
                            <li>
                                <a href="#second22" data-toggle='tab'><i class="icon-edit"></i> Editar</a>
                            </li>
                        </ul>
                        <div class="tab-content padding tab-content-inline tab-content-bottom">
                            <div class="tab-pane active" id="first11">
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
                                                    <tr>
                                                        <th>Data:</th>
                                                        <td>Aug 06, 2012</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Fator:</th>
                                                        <td>
                                                            {{$quote->fator}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total:</th>
                                                        <td>
                                                            {{$quote->total}}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
            
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <div class="basic-margin" style="float:right;">
                                                @if(!$quote->close)
                                                <a href="#new-task" data-toggle="modal" class="btn btn-primary"><i class="icon-plus-sign"></i> Adicionar Produto</a>
                                                @else
                                                <a href="javascript:void(0)" class="btn btn-default" disabled="disabled"><i class="icon-plus-sign"></i> Adicionar Produto</a>
                                                <a href="#new-task" class="btn btn-primary" style=""><i class="icon-file-alt"></i> Exportar PDF</a>
                                                <a href="#new-task" class="btn btn-green" style="display: none"><i class="icon-table"></i> Exportar Excel</a>
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
                                </div>
                            </div>
                            <div class="tab-pane" id="second22">
                                {{ Form::open(['route' => ['cotacoes.update', $quote->id], 'class' => 'form']) }}    
                                    @csrf 
                                    @method('PUT')
    
                                    <div class="row-fluid">
                                        <div class="span2">
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
                                        <div class="span2">
                                            <div class="control-group">
                                                <label for="total" class="control-label">Fator</label>
                                                <div class="controls controls-row">
                                                    //
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span2">
                                            <div class="control-group">
                                                <label for="total" class="control-label">Valor Total</label>
                                                <div class="controls controls-row">
                                                    //
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="row-fluid">
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                        </div>
                                    </div>
                                </form>
                            </div><!--Tab 2-->
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
                        {{Form::label('icms', 'ICMS', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('icms', '', ['id' => 'icms','placeholder' => '0.00', 'class' => 'decimal input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('ipi', 'IPI', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('ipi', '', ['id' => 'ipi','placeholder' => '0.00', 'class' => 'decimal input-medium', 'disabled' => true])}}
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
            getTable();
        }
    });
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
            getTable();
        }
    });
}

function getTable()
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
        }
    });
}

getTable();
</script>

    
@endsection
