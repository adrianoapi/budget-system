@extends('layouts.login')

@section('content')

    <h2>Autenticação</h2>
    <form action="{{route('login.auth')}}" method='POST' class='form-validate' id="test">
        @csrf
        <div class="control-group">
            <div class="email controls">
                <input type="text" name='email' value="" placeholder="Email address" class='input-block-level' data-rule-required="true" data-rule-email="true">
            </div>
        </div>
        <div class="control-group">
            <div class="pw controls">
                <input type="password" name="password" value="" id="password" placeholder="Password" class='input-block-level' data-rule-required="true">
            </div>
        </div>
        <div class="submit">
            <div class="remember">
                <input type="checkbox"
                name="remember"
                class='icheck-me'
                data-skin="square"
                data-color="blue"
                id="show-password">
                <label for="show-password">Exibir senha</label>
            </div>
            <input type="submit" value="Autenticar" class='btn btn-primary'>
        </div>
    </form>
    <div class="forget">
        <a href="{{route('login.recover')}}"><span>Deseja recuperar sua senha?</span></a>
    </div>

    <script>
        $(document).ready(function () {
            $('#show-password').val($(this).is(':checked'));
            $('#show-password').change(function () {
                if ($(this).is(":checked")) {
                    $('#password').attr('type', 'text');
                } else {
                    $('#password').attr('type', 'password');
                }
            });
        });

        $("#email").focus();
    </script>
@endsection


