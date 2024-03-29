<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public function Actions()
    {
        return $this->hasOne(Action::class, 'message_id', 'id')->orderBy('id', 'desc');
    }
}
