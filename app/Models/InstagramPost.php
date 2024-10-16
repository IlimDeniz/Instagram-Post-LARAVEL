<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstagramPost extends Model
{
    use HasFactory;

    protected $fillable = ['media_id', 'media_type', 'media_url', 'permalink', 'caption', 'posted_at'];
}

