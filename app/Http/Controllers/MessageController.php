<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends UtilController 
{
    private $title = "Mensagem";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->levelCheck();
        
        $title = NULL;
        $type  = NULL;

        if(array_key_exists('filtro',$_GET))
        {
            # Pega todos os id de estudantes onde
            # algum dos campos atenda ao menos
            # uma coluna abaixo.
            $title = $_GET['title' ];
            $type  = $_GET['type'];

            $messages = Message::select("id")
            ->where('title', 'like', '%' . $title . '%')
            ->get();

            $ids = [];
            foreach($messages as $value):
                array_push($ids, $value->id);
            endforeach;

            if(!empty($type))
            {
                $messages = Message::whereIn('id', $ids)
                ->where('type', $type)
                ->get();

                $ids = [];
                foreach($messages as $value):
                    array_push($ids, $value->id);
                endforeach;                
            }

            $messages = Message::whereIn('id', $ids)->orderBy('id', 'desc')->paginate(100);

        }else{
            $messages = Message::orderBy('id', 'desc')->paginate(100);
        }

        $header = $this->title. " listagem";
        
        return view('messages.index', [
            'header'   => $header,
            'messages' => $messages,
            'types'    => $this->messageTypes(),
            'type'     => $type,
            'title'    => $title
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        return view('messages.show', ['message' => $message]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function mail(Message $message)
    {
        return view('messages.mail', ['message' => $message]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
