<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'total_price'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class , 'order_products');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}