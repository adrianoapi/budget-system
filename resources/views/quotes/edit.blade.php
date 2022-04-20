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
                            <i class="icon-money"></i>
                            Cotação
                        </h3>
                    </div>
                    <div class="box-content">
                        <div class="invoice-info">
                            <div class="invoice-from">
                                <span>De</span>
                                <strong>Company Name</strong>
                                <address>
                                    Street Address <br>
                                    City, ST ZIP Code <br>
                                    <abbr title="Phone">Phone:</abbr> (125) 358123-581 <br>
                                    <abbr title="Fax">Fax:</abbr> (125) 251656-222 
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
                                    <tbody><tr>
                                        <th>Date:</th>
                                        <td>Aug 06, 2012</td>
                                    </tr>
                                    <tr>
                                        <th>Invoice #:</th>
                                        <td>0001752188s</td>
                                    </tr>
                                    <tr>
                                        <th>Product:</th>
                                        <td>Service Hotline</td>
                                    </tr>
                                </tbody></table>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="span12">
                                <div class="basic-margin" style="float:right;">
                                    <a href="#new-task" data-toggle="modal" class="btn btn-blue"><i class="icon-plus-sign"></i> Adicionar Produto</a>
                                </div>
                            </div>
                        </div>
                        
                        <div id="dinamic-table">Carregando...</div>

                        <div class="invoice-payment">
                            <span>Payment methods</span>
                            <ul>
                                
                            </ul>
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
                        {{Form::label('arco', 'Arco', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('arco', '', ['id' => 'arco','placeholder' => '0', 'class' => 'input-medium', 'disabled' => true])}}
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

const attributes = ['espessura', 'cobre', 'arco', 'valor', 'icms', 'ipi'];

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
