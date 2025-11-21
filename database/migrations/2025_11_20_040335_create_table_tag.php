<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel 'tags' untuk data master.
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('tag_id'); // Primary Key
            $table->string('name', 255); // Wajib Diisi (Contoh: "AI")
            $table->string('slug', 255)->unique(); // Unik, Wajib Diisi (Contoh: "ai")
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus tabel 'tags' saat rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
