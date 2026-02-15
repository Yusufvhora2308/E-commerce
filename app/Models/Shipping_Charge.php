<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping_Charge extends Model
{
    use HasFactory;

        public $timestamps = true;

            protected $fillable = ['charge_amount'];

}
