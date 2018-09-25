<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'order_id',
        'detail_id',
        'code',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function detail()
    {
        return $this->belongsTo(Detail::class);
    }


}
