<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel 'artikel' sesuai skema yang ditentukan.
     */
    public function up(): void
    {
        // Ganti 'table_artikel' (jika Anda menggunakan nama ini) menjadi 'artikel'
        // agar sesuai dengan konvensi Eloquent (Model Article -> tabel artikel).
        Schema::create('article', function (Blueprint $table) {
            // Primary Key
            $table->bigIncrements('article_id'); // article_id (BIGINT, Primary Key, Auto Increment)

            // Foreign Keys (Pastikan tabel 'users' sudah dibuat sebelum migrasi ini dijalankan)

            // writer_id (BIGINT, Foreign Key ke users.id)
            $table->unsignedBigInteger('writer_id')->comment('Penulis artikel');
            $table->foreign('writer_id')->references('id')->on('users')->onDelete('cascade');

            // editor_id (BIGINT, Foreign Key ke users.id, Nullable)
            $table->unsignedBigInteger('editor_id')->nullable()->comment('Editor yang mengklaim artikel');
            $table->foreign('editor_id')->references('id')->on('users')->onDelete('set null');

            // Kolom Konten Utama
            $table->string('title', 255)->comment('Judul artikel');
            $table->string('slug', 255)->unique()->comment('Slug unik untuk URL');
            $table->longText('content')->comment('Isi lengkap artikel');
            $table->string('thumbnail_path', 255)->nullable()->comment('Path/URL ke gambar thumbnail');

            // Kolom Kontrol Status
            $table->enum('status', ['draft', 'pending', 'published', 'archived'])
                  ->default('draft')
                  ->comment('Status alur kerja artikel');

            // Kolom Waktu
            $table->timestamp('published_at')->nullable()->comment('Waktu publikasi artikel');
            $table->timestamps(); // created_at dan updated_at (TIMESTAMP)
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus tabel 'artikel' saat rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('article');
    }
};
