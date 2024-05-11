<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volume extends Model
{
    use HasFactory;

    public $pesoFixo = 20;

    public function Quote()
    {
        return $this->hasOne(Quote::class, 'id', 'quote_id');
    }

    public function volumeDefaultArray()
    {
        return [
            [
                'nome' => "Caixa de Tubo",
                'dimensao_a' => 208,
                'dimensao_b' => 42,
                'dimensao_c' => 30,
                'edit_dimensao_a' => false,
                'edit_dimensao_b' => false,
                'edit_dimensao_c' => false,
            ],
            [
                'nome' => "Rolo de Manta",
                'dimensao_a' => 100,
                'dimensao_b' => 60,
                'dimensao_c' => 60,
                'edit_dimensao_a' => false,
                'edit_dimensao_b' => false,
                'edit_dimensao_c' => false,
            ],
            [
                'nome' => "Outro 1",
                'dimensao_a' => 0,
                'dimensao_b' => 0,
                'dimensao_c' => 0,
                'edit_dimensao_a' => true,
                'edit_dimensao_b' => true,
                'edit_dimensao_c' => true,
            ],
            [
                'nome' => "Outro 2",
                'dimensao_a' => 0,
                'dimensao_b' => 0,
                'dimensao_c' => 0,
                'edit_dimensao_a' => true,
                'edit_dimensao_b' => true,
                'edit_dimensao_c' => true,
            ],
            [
                'nome' => "Outro 3",
                'dimensao_a' => 0,
                'dimensao_b' => 0,
                'dimensao_c' => 0,
                'edit_dimensao_a' => true,
                'edit_dimensao_b' => true,
                'edit_dimensao_c' => true,
            ]
        ];
    }
}
