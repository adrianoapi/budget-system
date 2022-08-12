@extends('layouts.mail')
@section('content')
<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff">
    <tr>
        <td align="center">
            <center>
                <table border="0" width="600" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="color:#333333 !important; font-size:20px; font-family: Arial, Verdana, sans-serif; padding-left:10px;" height="40">
                            <h3 style="font-weight:normal; margin: 20px 0;">Recuperação de senha</h3>
                            <p style="font-size:12px; line-height:18px;">
                                Sua nova senha: <strong>{{$details['password']}}</strong>
                            </p>
                            <p style="font-size:12px; line-height:18px;">
                                <a href="{{env('APP_URL')}}">Click aqui para acessar sua conta</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table>
@endsection
