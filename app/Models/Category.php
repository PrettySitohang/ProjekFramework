<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    // 1. Definisikan Primary Key
    // Karena PK-nya BUKAN 'id', kita harus mendefinisikannya.
    protected $primaryKey = 'category_id';

    // 2. Kolom yang dapat diisi (Mass Assignable)
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS (Hubungan ke Tabel Lain)
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke Artikel (Article). (Many-to-Many)
     * Satu kategori bisa dimiliki oleh banyak artikel.
     */
    public function articles(): BelongsToMany
    {
        // Parameter 1: Model tujuan (Article)
        // Parameter 2: Nama tabel pivot (article_category)
        // Parameter 3: Foreign Key di tabel Category (id)
        // Parameter 4: Foreign Key di tabel Article (article_id)
    return $this->belongsToMany(Article::class, 'article_category', 'category_id', 'article_id');    }
}
