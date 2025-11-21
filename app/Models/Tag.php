<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    // 1. Definisikan Primary Key
    protected $primaryKey = 'id';

    // 2. Kolom yang dapat diisi (Mass Assignable)
    protected $fillable = [
        'name',
        'slug',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS (Hubungan ke Tabel Lain)
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke Artikel (Article). (Many-to-Many)
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_tag', 'id', 'article_id');
    }
}
