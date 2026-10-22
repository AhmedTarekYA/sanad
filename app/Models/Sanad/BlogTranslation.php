<?php

namespace App\Models\Sanad;

use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['title', 'description', 'slug'];
}
