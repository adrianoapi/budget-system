<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    public function Client()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function Items()
    {
        return $this->hasMany(Item::class, 'quote_id', 'id')->orderBy('created_at', 'desc');
    }

    public function Company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function setTotalAttribute($value)
    {
        return $this->attributes['total'] = str_replace(',', '.', str_replace('.', '', $value));
    }

    public function getTotalAttribute($value)
    {
        return $this->attributes['total'] = $value;
    }

    public function setPercentualAttribute($value)
    {
        return $this->attributes['percentual'] = str_replace(',', '.', str_replace('.', '', $value));
    }

    public function getPercentualAttribute($value)
    {
        return $this->attributes['percentual'] = $value;
    }

    public function setFreteAttribute($value)
    {
        return $this->attributes['frete'] = str_replace(',', '.', str_replace('.', '', $value));
    }

    public function getFreteAttribute($value)
    {
        return $this->attributes['frete'] = $value;
    }
}
