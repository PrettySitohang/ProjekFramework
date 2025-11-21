<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;

    protected $table = 'article';
    protected $primaryKey = 'article_id';
    protected $fillable = [
        'writer_id',
        'editor_id',
        'title',
        'slug',
        'content',
        'thumbnail_path',
        'status',
        'published_at',
    ];


    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Relasi ke Penulis (Writer). (One-to-Many terbalik)
     * article.writer_id -> users.user_id
     */
    public function writer(): BelongsTo
    {
        // Parameter pertama: Model tujuan
        // Parameter kedua: Foreign Key di tabel Article
        // Parameter ketiga: Primary Key di tabel User (jika bukan 'id')
        return $this->belongsTo(User::class, 'writer_id', 'user_id');
    }

    /**
     * Relasi ke Editor. (One-to-Many terbalik)
     * article.editor_id -> users.user_id
     */
    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id', 'user_id');
    }

    /**
     * Relasi ke Kategori (Many-to-Many)
     * Artikel bisa punya banyak kategori, Kategori bisa punya banyak artikel.
     * Menggunakan tabel pivot: 'article_category'
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'article_category', 'article_id', 'id');
    }

    /**
     * Relasi ke Tags (Many-to-Many)
     * Menggunakan tabel pivot: 'article_tag'
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'article_tag', 'article_id', 'id');
    }

    /**
     * Relasi ke Revisi (One-to-Many)
     * Artikel bisa punya banyak riwayat revisi (log).
     */
    public function revisions(): HasMany
    {
        // 'article_id' adalah Foreign Key di tabel ArticleRevision
        return $this->hasMany(ArticleRevision::class, 'article_id');
    }
}
