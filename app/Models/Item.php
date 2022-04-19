<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function Quote()
    {
        return $this->hasOne(Quote::class, 'id', 'quote_id');
    }

    public function Product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
