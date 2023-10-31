<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article_categorie extends Model
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

    public function article()
    {
        return $this->belongsTo(\App\Models\Article::class);
    }

    public function categories()
    {
        return $this->belongsTo(\App\Models\Categorie::class, 'categorie_id');
    }
}
