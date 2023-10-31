<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];

    public function articles()
    {
        return $this->belongsTo(\App\Models\Article::class, 'article_id');
    }

    public function users()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
