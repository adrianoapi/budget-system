@extends('layouts.login')

@section('content')

    <h2>Recuperação de senha</h2>
    <form action="{{route('login.recover.do')}}" method='POST' class='form-validate' id="test">
        @csrf
        <div class="control-group">
            <div class="email controls">
                <input type="text" name='email' value="" placeholder="Email address" class='input-block-level' data-rule-required="true" data-rule-email="true">
            </div>
        </div>
        <div class="submit">
            <input type="submit" value="Recuperar" class='btn btn-primary'>
        </div>
    </form>
    <div class="forget">
        <a href="{{route('login')}}"><span>Área de autenticação</span></a>
    </div>

@endsection
