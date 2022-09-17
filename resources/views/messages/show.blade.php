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
                            <h3><i class="icon-th-list"></i> Mensagem</h3>
                        </div>
                        <div class="box-content nopadding">
                            <form action="" method="POST" class='form-horizontal form-bordered'>
                                <div class="control-group">
                                    <label for="name" class="control-label">Título</label>
                                    <div class="controls">
                                        <input type="text" name="title" id="title" value="{{$message->title}}" class="input-xlarge" disabled>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="email" class="control-label">Tipo</label>
                                    <div class="controls">
                                        <input type="text" name="type" id="type" value="{{$message->type}}" class="input-xlarge" disabled>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="executed" class="control-label">Executed</label>
                                    <div class="controls">
                                        <input type="text" name="type" id="executed" value="{{$message->actions->executed}}" class="input-xlarge" disabled>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="email" class="control-label">Corpo</label>
                                    <div class="controls">
                                        @if($message->type == 'alert')
                                        <input type="text" name="type" id="type" value="{{$message->body}}" class="input-xlarge" disabled>
                                        @else
                                        <a href="{{route('show.mail', $message->id)}}" target="_blank">Visualizar</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script>

(function( $ ) {
    $(function() {
        $('.money').mask('#.##0,00', {reverse: true});
        $('.decimal').mask('##########.##', {reverse: true});
    });
})(jQuery);

</script>

@endsection
