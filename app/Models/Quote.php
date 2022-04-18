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
}
