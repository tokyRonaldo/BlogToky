<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
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

    public function article_categories()
    {
        return $this->hasMany(\App\Models\Article_categorie::class);
    }

    public function commentaires()
    {
        return $this->hasMany(\App\Models\Commentaire::class);
    }

    public function medias()
    {
        return $this->hasMany(\App\Models\Media::class);
    }

    public function users()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(\App\Models\Categorie::class)
            ->withPivot('article_id', 'categorie_id'); // Remplacez 'colonne1', 'colonne2', 'colonne3' par les noms de colonnes que vous souhaitez récupérer.
    }
}
