<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function Message()
    {
        return $this->hasOne(Message::class, 'id', 'message_id')->orderBy('id', 'desc');
    }
}
