<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'address',
        'city',
        'state',
        'zip',
        'shipping_method',
        'shipping_cost',
        'subtotal',
        'total',
        'payment_id',
        'payment_method',
        'payment_status',
        'status'
    ];
  public function items() {
        return $this->hasMany(Orderitem::class);
    }

      public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
