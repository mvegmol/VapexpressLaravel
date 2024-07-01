<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
//Pivot: para la tabla intermedia
class CategoryProduct extends Pivot
{
    use HasFactory;
}
