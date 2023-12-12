<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'token_address', 'balance'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
