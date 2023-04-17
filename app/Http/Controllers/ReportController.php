<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quote;
use App\Models\Client;

class ReportController extends UtilController
{
    private $dtInicial;
    private $dtFinal;

    public function __construct()
    {
        $this->middleware('auth');

        $this->title     = 'Relatório';
        $this->dtInicial = date('Y-m-01');
        $this->dtFinal   = date('Y-m-t' );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title. " listagem";

        $ids          = [];
        $quoteIds     = [];
        $name         = NULL;
        $close        = NULL;
        $aprovado     = NULL;
        $serial       = NULL;
        $numero_nf    = NULL;

        if(array_key_exists('filtro', $_GET))
        {
            $name        = $_GET['name'       ];
            $close       = $_GET['close'      ];
            $aprovado    = $_GET['aprovado'   ];
            $serial      = $_GET['serial'     ];
            $numero_nf   = $_GET['numero_nf'  ];

            $this->dtInicial = strlen($_GET['dt_inicio']) > 2 ? $this->dataSql($_GET['dt_inicio']) : $this->dtInicial;
            $this->dtFinal   = strlen($_GET['dt_fim'   ]) > 2 ? $this->dataSql($_GET['dt_fim'   ]) : $this->dtFinal;

            # Se for administrador
            if(Auth::user()->level > 1)
            {
                $clients = Client::select('id')->where('name', 'like', '%' . $name . '%')
                ->where('active', true)
                ->orderBy('name', 'asc')
                ->get();
            }else{
                $clients = Client::select('id')->where('name', 'like', '%' . $name . '%')
                ->where('active', true)
                ->where('user_id', Auth::user()->id)
                ->orderBy('name', 'asc')
                ->get();
            }

            foreach($clients as $value):
                array_push($ids, $value->id);
            endforeach;

        }else{
            # Se for administrador
            if(Auth::user()->level > 1)
            {
                $clients = Client::select('id')
                ->where('active', true)
                ->get();
            }else{
                $clients = Client::select('id')
                ->where('active', true)
                ->where('user_id', Auth::user()->id)
                ->get();
            }

            foreach($clients as $value):
                array_push($ids, $value->id);
            endforeach;

        }

        if(!empty($close))
        {
            $quotes = Quote::select('id')->whereIn('client_id', $ids)
            ->where('active', true)
            ->where('serial', 'like', '%' . rtrim($serial) . '%')
            ->where('close', $close == "yes" ? true : false)
            ->orderBy('id', 'desc')
            ->get();

        }else{
            $quotes = Quote::select('id')->whereIn('client_id', $ids)
            ->where('active', true)
            ->where('serial', 'like', '%' . rtrim($serial) . '%')
            ->orderBy('id', 'desc')
            ->get();

        }
    
        foreach($quotes as $value):
            array_push($quoteIds, $value->id);
        endforeach;
        
        if(!empty($aprovado))
        {
            $quotes = Quote::select('id')->whereIn('id', $quoteIds)
            ->where('aprovado', $aprovado == "yes" ? true : false)
            ->orderBy('id', 'desc')
            ->get();

            $quoteIds = [];
            foreach($quotes as $value):
                array_push($quoteIds, $value->id);
            endforeach;

        }

        if(!empty($aprovado))
        {
            $quotes = Quote::select('id')->whereIn('id', $quoteIds)
            ->where('aprovado', $aprovado == "yes" ? true : false)
            ->get();

            $quoteIds = [];
            foreach($quotes as $value):
                array_push($quoteIds, $value->id);
            endforeach;

        }

        if(!empty($this->dtInicial) && !empty($this->dtFinal))
        {
            if($this->dtInicial > $this->dtFinal)
            {
                return redirect()->route('relatorios.index')->with(
                    'quote_filter',
                    'A data Inicial não pode ser maior que a data Final!'
                );
            }else{
                $quotes = Quote::select('id')->whereIn('id', $quoteIds)
                ->where('active', true)
                ->where('created_at', '>=', $this->dtInicial.' 00:00:00')
                ->where('created_at', '<=', $this->dtFinal.' 23:59:59')
                ->orderBy('id', 'desc')
                ->get();
                
                $quoteIds = [];
                foreach($quotes as $value):
                    array_push($quoteIds, $value->id);
                endforeach;
            }
        }else{
            return redirect()->route('relatorios.index')->with(
                'quote_filter',
                'Informe um intervalo de data!'
            );
        }
            

        $quotes = Quote::whereIn('id', $quoteIds)
        ->where('numero_nf', 'like', '%' . $numero_nf . '%')
        ->orderBy('id', 'desc')
        ->get();
        
        return view('reports.index', [
            'title'       => $title,
            'quotes'      => $quotes,
            'name'        => $name,
            'close'       => $close,
            'aprovado'    => $aprovado,
            'numero_nf'   => $numero_nf,
            'serial'      => $serial,
            'dt_inicio'   => !empty($this->dtInicial) ? $this->dataBr($this->dtInicial) : NULL,
            'dt_fim'      => !empty($this->dtFinal  ) ? $this->dataBr($this->dtFinal  ) : NULL
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
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
