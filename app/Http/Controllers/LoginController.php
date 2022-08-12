<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\RecoverMail;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function auth(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'active' => 1
        ];

        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            return \redirect()->back()->withInput()->withErrors(['Email informado não é válido!']);
        }

        if(Auth::attempt($credentials)){
            return \redirect()->route('dashboard.index');
        }

        return \redirect()->back()->withInput()->withErrors(['Dados informados não conferem!']);
    }

    public function logout()
    {
        Auth::logout();
        return \redirect()->route('auth.login');
    }

    public function recover()
    {
        return view('auth.recover');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function recoverDo(Request $request)
    {
        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            return \redirect()->back()->withInput()->withErrors(['Email informado não é válido!']);
        }

        $user = User::where('email', $request->email)
                        ->where('active', true)
                        ->limit(1)
                        ->get();

        if(count($user))
        {
            $newPassowrd = $this->passowrdGenerate();
            $model = User::where('id', $user[0]->getAttributes()['id'])->first();
            $model->password  = \Illuminate\Support\Facades\Hash::make($newPassowrd);

            if($model->save())
            {
                $details = [
                    'title' => 'Mail recover password',
                    'password' => $newPassowrd
                ];
                
                Mail::to($request->email)->send(new RecoverMail($details));

                if (Mail::failures()) {
                    die('Erro no envio de e-mail');
                }

                return \redirect()->route('login')
                ->with(
                    'password_recover',
                    'Senha enviada com sucesso para o e-mail:<br><strong>'.$request->email.'</strong>'
                );
            }
        }else{
            return \redirect()->route('login.recover')->with(
                'password_recover',
                'E-mail não encontrado.<br>Certifique-se de que digitou o e-mail certo ou se o usuário esta ativo.'
            );
        }
    }

    public function passowrdGenerate()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass    = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

}
