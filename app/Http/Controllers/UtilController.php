<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class UtilController extends Controller
{
    protected $levels = [
        1 => 'Representante',
        2 => 'Gerente',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function levelCheck()
    {
        if(Auth::user()->level <= 1){
            die('Você não tem permissão!');
        }
    }

    public function autoridadeCheck($user_id)
    {
        if(Auth::user()->level <= 1){
            if(Auth::id() != $user_id){
                die('Não encontrado! Error: auth');
            }
        }
    }

    public function getEstados()
    {
        return [
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AP' => 'Amapá',
            'AM' => 'Amazonas',
            'BA' => 'Bahia',
            'CE' => 'Ceará',
            'DF' => 'Distrito Federal',
            'ES' => 'Espírito Santo',
            'GO' => 'Goiás',
            'MA' => 'Maranhão',
            'MT' => 'Mato Grosso',
            'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais',
            'PA' => 'Pará',
            'PB' => 'Paraíba',
            'PR' => 'Paraná',
            'PE' => 'Pernambuco',
            'PI' => 'Piauí',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul',
            'RO' => 'Rondônia',
            'RR' => 'Roraima',
            'SC' => 'Santa Catarina',
            'SP' => 'São Paulo',
            'SE' => 'Sergipe',
            'TO' => 'Tocantins',
        ];
    }
}