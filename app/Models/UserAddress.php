<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $table = 'user_address';
    protected $fillable = [
        'type',
        'address1',
        'address2',
        'city',
        'state',
        'zipcode',
        'isMain',
        'country_code',
        'user_id',
    ];

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
