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

    public function messageTypes()
    {
        return [
            'alert' => 'Alerta',
            'email' => 'E-mail'
        ];
    }

    public function getRamal()
    {
        return [
            'AC' => '68',
            'AL' => '82',
            'AP' => '96',
            'AM' => '92',
            'BA' => '71',
            'CE' => '88',
            'DF' => '61',
            'ES' => '28',
            'GO' => '62',
            'MA' => '98',
            'MT' => '65',
            'MS' => '67',
            'MG' => '31',
            'PA' => '91',
            'PB' => '83',
            'PR' => '41',
            'PE' => '87',
            'PI' => '86',
            'RJ' => '21',
            'RN' => '84',
            'RS' => '51',
            'RO' => '69',
            'RR' => '95',
            'SC' => '47',
            'SP' => '11',
            'SE' => '79',
            'TO' => '63',
        ];
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

    public function fatorLista()
    {
        return [
            0 => '1.0', 
            9 => '0.9', 
            8 => '0.8', 
            7 => '0.7', 
            6 => '0.6', 
            5 => '0.5', 
            4 => '0.4', 
            3 => '0.3', 
            2 => '0.2', 
            1 => '0.1' 
        ];
    }

    public function icmsLista()
    {
        return [
            'inclusivo' => 'inclusivo', 
            '4'  => '4%', 
            '12' => '12%', 
            '18' => '18%', 
        ];
    }

    public function ipiLista()
    {
        return [
            'inclusivo' => 'inclusivo', 
            'isento'  => 'isento', 
            '6.5' => '6,50%', 
        ];
    }

    public function dataSql($value)
    {
        $date = str_replace('/', '-', $value);
        return date("Y-m-d", strtotime($date));
    }

    public function dataBr($value)
    {
        return date("d/m/Y", strtotime($value));
    }
}