<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Categorybrand;

class Brand extends Model
{
    use HasFactory;

      public function categorybrands()
    {
        return $this->hasMany(Categorybrand::class);
    }
}
