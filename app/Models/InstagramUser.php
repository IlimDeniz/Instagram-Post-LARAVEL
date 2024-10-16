<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstagramUser extends Model
{
    use HasFactory;

    protected $fillable = ['username', 'user_id', 'access_token', 'token_expired_at'];
}
