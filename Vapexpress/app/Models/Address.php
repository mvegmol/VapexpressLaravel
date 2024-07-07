<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected  $fillable = ['user_id', 'direction', 'province', 'zip_code', 'is_default', 'city', 'full_name', 'contact_phone'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
