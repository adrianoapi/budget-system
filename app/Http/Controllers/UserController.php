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


        $ids   = [];
        $name  = NULL;
        $email = NULL;
        $level = NULL;

        if(array_key_exists('filtro',$_GET))
        {
            # Pega todos os id de estudantes onde
            # algum dos campos atenda ao menos
            # uma coluna abaixo.
            $name  = $_GET['name' ];
            $email = $_GET['email'];
            $level = $_GET['level'];

            $users = User::select("id")->where('name', 'like', '%' . $name . '%')
            ->where('active', true)
            ->where('email', 'like', '%' . $email . '%')
            ->get();

            $ids = [];
            foreach($users as $value):
                array_push($ids, $value->id);
            endforeach;

            if(strlen($level))
            {
                $students = User::whereIn('id', $ids)
                ->where('level', $level)
                ->get();

                $ids = [];
                foreach($students as $value):
                    array_push($ids, $value->id);
                endforeach;                
            }

            $users = User::whereIn('id', $ids)->orderBy('name', 'asc')->paginate(100);

        }else{
            $users = User::where('active', true)->orderBy('name', 'asc')->paginate(100);
        }

        $title = $this->title. " listagem";
        
        return view('users.index', [
            'title' => $title,
            'users' => $users,
            'levels' => $this->levels,
            'name' => $name,
            'email' => $email,
            'level' => $level
        ]);
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
        $request->validate([
            'name'     => 'required|min:5',
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $this->levelCheck();
        $model = new User();
        $model->name      = $request->name;
        $model->email     = $request->email;
        $model->password  = Hash::make($request->password);
        $model->level     = !empty($request->level) ? $request->level : 1;
        $model->active    = true;
        $model->comissao  = "0.00";
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
