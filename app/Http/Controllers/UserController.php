<?php

namespace App\Http\Controllers;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\File;
use Illuminate\Support\Facades\File as FileBase;
use Illuminate\Http\Request;

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
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clientsList(Request $request)
    {
        $model = \App\Models\Client::where('user_id', $request->id)->get();
        return response()->json($model);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeImage(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png|max:4196'
        ]);

        if($request->file())
        {
            $model = new File();
            $model->quote_id = $request->quote_id;
            $model->type     = $request->file->getMimeType();
            $model->size     = $request->file->getSize();

            $ext = explode('/', $model->type);

            $modelUser = User::where('id', Auth::user()->id)->firstOrFail();

            $fileName = 'logo_'.$modelUser->id.'.'.end($ext);
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            

            

            if($request->file->move('./'.getenv('UPLOAD_DIRECTORY'), $fileName))
            {
                $modelUser->logo = $fileName;
                if($modelUser->save())
                {
                    return redirect()->route('usuarios.profile')->with(
                        'success_file',
                        'Arquivo enviado com sucesso!'
                    );
                    
                }else{
                    return redirect()->route('usuarios.profile')->with(
                        'failure_file',
                        'Erro ao enviar o arquivo!'
                    );
                }

            }else{
                echo 'Falha ao subir o arquivo!';
            }
        }

    

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function imgShow(Request $request)
    {
        $file = './'.getenv('UPLOAD_DIRECTORY').'/'.$request->logo;

        $ext = explode('.', $request->logo);

        header("Content-Type: image/".end($ext)); 
        header("X-Sendfile: $file");

        readfile ($file);
        exit(); 
    }

    public function destroyImage()
    {
        $user = User::where('id', Auth::user()->id)->firstOrFail();
        if(FileBase::delete('./'.getenv('UPLOAD_DIRECTORY').'/'.$user->logo))
        {
            $user->logo = NULL;
            $user->save();
            
            return redirect()->route('usuarios.profile')->with(
                'success_file',
                'Arquivo excluido com sucesso!'
            );
            
        }else{
            return redirect()->route('usuarios.profile')->with(
                'failure_file',
                'Erro ao excluir o arquivo!'
            );
        }
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
