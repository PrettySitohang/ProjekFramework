<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleRevision extends Model
{
    use HasFactory;

    // 1. Definisikan nama tabel secara eksplisit
    protected $table = 'article_revisions';

    // 2. Definisikan Primary Key
    protected $primaryKey = 'revision_id';

    // 3. Matikan timestamps 'updated_at'
    // Karena ini adalah LOG, kita hanya peduli pada 'created_at'.
    const UPDATED_AT = null;

    // 4. Kolom yang dapat diisi (Mass Assignable)
    protected $fillable = [
        'article_id',
        'id', // Editor yang melakukan revisi
        'title_before',
        'content_before',
        'title_after',
        'content_after',
        'notes',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS (Hubungan ke Tabel Lain)
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke Artikel (Article). (One-to-Many terbalik)
     * Mengambil data artikel yang direvisi.
     */
    public function article(): BelongsTo
    {
        // article_id adalah Foreign Key di tabel ini.
        return $this->belongsTo(Article::class, 'article_id', 'article_id');
    }

    /**
     * Relasi ke Editor (User) yang melakukan revisi. (One-to-Many terbalik)
     * Mengambil data editor yang membuat log revisi.
     */
    public function editor(): BelongsTo
    {
        // id adalah Foreign Key, merujuk ke id di tabel users.
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
