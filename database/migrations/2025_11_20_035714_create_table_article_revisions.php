<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel 'article_revisions' untuk menyimpan log perubahan editor.
     */
    public function up(): void
    {
        Schema::create('article_revisions', function (Blueprint $table) {
            // Primary Key
            $table->bigIncrements('revision_id'); // revision_id

            // Foreign Keys

            // article_id (FK ke artikel.article_id)
            $table->unsignedBigInteger('article_id')->comment('ID Artikel yang direvisi');
            $table->foreign('article_id')->references('article_id')->on('artikel')->onDelete('cascade');

            // id (FK ke users.id, Editor yang melakukan revisi)
            $table->unsignedBigInteger('id')->comment('ID Editor yang membuat revisi');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');

            // Konten Sebelum Revisi
            $table->string('title_before', 255)->comment('Judul artikel sebelum revisi');
            $table->longText('content_before')->comment('Konten artikel sebelum revisi');

            // Konten Setelah Revisi
            $table->string('title_after', 255)->comment('Judul artikel setelah revisi');
            $table->longText('content_after')->comment('Konten artikel setelah revisi');

            // Catatan Editor
            $table->text('notes')->nullable()->comment('Catatan/alasan revisi dari editor');

            // Kolom Waktu
            $table->timestamps(); // created_at (Waktu revisi disimpan) dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus tabel 'article_revisions' saat rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_revisions');
    }
};
