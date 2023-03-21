<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function Produto()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function setDtLancamentoAttribute($value)
    {
        $date = str_replace('/', '-', $value);
        return $this->attributes['dt_lancamento'] = date("Y-m-d", strtotime($date));
    }

    public function getDtLancamentoAttribute($value)
    {
        return $this->attributes['dt_lancamento'] = date("d/m/Y", strtotime($value));
    }
}
