<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cvs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_file');                              // nama file yang diinput user
            $table->enum('bahasa', ['id', 'en'])->default('id');     // id = Indonesia, en = English
            $table->enum('status', ['draft', 'completed'])->default('draft');
            $table->json('content')->nullable();                      // semua isi CV disimpan sebagai JSON
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cvs');
    }
};
