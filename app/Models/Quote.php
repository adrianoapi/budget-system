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
}
