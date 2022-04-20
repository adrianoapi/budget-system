<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends UtilController
{
    private $title  = 'Usuário';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->levelCheck();
        $title = $this->title. " listagem";
        $users = User::where('active', true)->orderBy('name', 'asc')->paginate(100);

        return view('users.index', ['title' => $title, 'users' => $users, 'levels' => $this->levels]);
    }

    public function profile()
    {
        $title = $this->title. " perfil";
        $user = User::where('id', Auth::user()->id)->firstOrFail();
        return view('users.perfil', ['title' => $title, 'user' => $user, 'levels' => $this->levels]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function upProfile(Request $request, User $user)
    {
        if($user->id === Auth::user()->id){

            $user->name  = $request->name;
            $user->email = $request->email;

            if(!empty($request->password))
            {
                if($request->password === $request->password_confirm)
                {
                    $user->password = Hash::make($request->password);
                    
                }else{
                    die('Erro: Senha diferente de confirmação de senha!');
                }
            }

            if($user->save())
            {
                return redirect()->route('login.logout');
            }

        }else{
            die('Usuário não encontrado');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->levelCheck();
        $title = $this->title. " cadastar";

        return view('users.add', ['title' => $title, 'levels' => $this->levels]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->levelCheck();
        $model = new User();
        $model->name      = $request->name;
        $model->email     = $request->email;
        $model->password  = Hash::make($request->password);
        $model->level     = !empty($request->level) ? $request->level : 1;
        $model->active    = true;
        $model->comissao  = str_replace(',', '.', str_replace('.', '', $request->comissao));
        $model->save();

        return redirect()->route('usuarios.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->levelCheck();
        $title = $this->title. " alterar";
        return view('users.edit', ['title' => $title, 'levels' => $this->levels, 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->levelCheck();
        $user->name      = $request->name;
        $user->level     = $request->level;
        $user->comissao  = str_replace(',', '.', str_replace('.', '', $request->comissao));
        
        if(filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            $user->email = $request->email;
        }
        
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->updated_user_id = Auth::id();
        $user->save();

        return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->levelCheck();
        $user->active = false;
        $user->deactivate_user_id = Auth::id();
        $user->save();

        return redirect()->route('usuarios.index');
    }

}
