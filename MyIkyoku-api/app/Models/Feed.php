<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'rss_link',
        'website_link',
        'copyright',
    ];
}
