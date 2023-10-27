<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Facades\File as FileBase;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('files.add');
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
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf,jpg,jpeg,png|max:4196'
        ]);

        if($request->file())
        {
            $model = new File();
            $model->quote_id = $request->quote_id;
            $model->type     = $request->file->getMimeType();
            $model->size     = $request->file->getSize();

            $fileName = time().'_'.$request->file->getClientOriginalName();
            if($request->file('file')->storeAs('uploads', $fileName, '../../../public'))
            {
                $model->name = $fileName;
                if($model->save())
                {
                    return redirect()->route('cotacoes.edit', ['quote' => $request->quote_id])->with(
                        'success_file',
                        'Arquivo enviado com sucesso!'
                    );
                    
                }else{
                    return redirect()->route('cotacoes.edit', ['quote' => $request->quote_id]);
                }

            }else{
                echo 'Falha ao subir o arquivo!';
            }
        }

    

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        $file = './'.getenv('UPLOAD_DIRECTORY').'/'.$file->name;

        header("Content-Description: File Transfer"); 
        header("Content-Type: application/octet-stream"); 
        header("Content-Disposition: attachment; filename=\"". basename($file) ."\""); 

        readfile ($file);
        exit(); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        if(FileBase::delete('./'.getenv('UPLOAD_DIRECTORY').'/'.$file->name))
        {
            if($file->delete())
            {
                return redirect()->route('cotacoes.edit', ['quote' => $file->quote_id])->with(
                    'success_file',
                    'Arquivo excluído com sucesso!'
                );

            }else{
                die('Erro ao excluir o Arquivo!');
            }
        }else{
            echo 'Arquivo não encontrado!';
        }
    }
}
