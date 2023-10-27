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
                            <h3><i class="icon-th-list"></i> {{$title}}</h3>
                        </div>

                        <div class="box-content nopadding">

                            <div class="tabs-container">
                                <ul class="tabs tabs-inline tabs-top">
                                    <li class='active'>
                                        <a href="#first11" data-toggle='tab'><i class="icon-list-alt"></i> Resumo</a>
                                    </li>
                                    <li>
                                        <a href="#second" data-toggle='tab'><i class="icon-picture"></i> Logotipo</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content tab-content-inline tab-content-bottom">

                                <div class="tab-pane active" id="first11">
                                    <form action="{{route('usuarios.update.profile', ['user' => $user->id])}}" method="POST" class='form-horizontal form-bordered'>
                                        @csrf
                                        @method('PUT')
                                        <div class="control-group">
                                            <label for="name" class="control-label">Nome completo</label>
                                            <div class="controls">
                                                <input type="text" name="name" id="name" value="{{$user->name}}" placeholder="Insira o nome" class="input-xlarge" required>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="email" class="control-label">E-mail</label>
                                            <div class="controls">
                                                <input type="text" name="email" id="email" value="{{$user->email}}" placeholder="name@provider.domain" class="input-xlarge" required>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="password" class="control-label">Senha</label>
                                            <div class="controls">
                                                <input type="password" name="password" id="password" placeholder="******" class="input-xlarge">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="password_confirm" class="control-label">Senha confirmação</label>
                                            <div class="controls">
                                                <input type="password" name="password_confirm" id="password_confirm" placeholder="******" class="input-xlarge">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="level" class="control-label">Nível</label>
                                            <div class="controls">
                                                <select name="level" id="level" class='select2-me input-xlarge' disabled>
                                                    @foreach($levels as $id => $level)
                                                    <option value="{{$id}}" {{$id == $user->level ? 'selected':''}}>{{$level}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                            <a href="{{route('dashboard.index')}}" class="btn">Cancelar</a>
                                        </div>

                                    </form>

                                </div><!--Tab 1-->
                                
                                <div class="tab-pane" id="second">
                                    
                                    <form action="{{route('usuarios.store.img')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @if ($message = Session::get('success'))
                                        <div class="alert alert-success">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @endif
                                        @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif

                                        @if ($message = Session::get('success_file'))
                                        <div class="alert alert-success">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @endif
                                        
                                        <div class="custom-file">
                                            <input type="file" name="file" class="custom-file-input" id="chooseFile">
                                            <label class="custom-file-label" for="chooseFile">Selecione um arquivo!</label>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                                            Subir arquivo!
                                        </button>
                                    </form>
                                    @if(!empty($user->logo))
                                    <p><a href="{{route('usuarios.destroy.img')}}">Excluir imagem!</a></p>
                                    <!--<img src="{{route('usuarios.image.show', ['logo' => $user->logo])}}" alt="logo" width="500">-->
                                    <img src="./../public/{{$user->logo}}" alt="logo" width="300px" height="60px">
                                    @endif

                                </div><!--Tab second-->

                            </div>

                            
                        </div><!--box-content nopadding-->
                    </div><!--box box-bordered box-color-->
                </div><!--span12-->
            </div><!--row-fluid-->

        </div><!--container-fluid-->
    </div><!--/main-->

</div>

@endsection
