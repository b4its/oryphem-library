<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->timestamps();
        });

        Schema::create('book', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('idCategory')->nullable()->constrained('category')->onDelete('cascade');
            $table->text('descriptions')->nullable();
            $table->string('link')->nullable();
            $table->integer('price')->nullable()->default(1);
            $table->integer('sold')->nullable()->default(1);
            $table->string('gambar')->nullable();
            $table->text('book_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book');
        Schema::dropIfExists('category');
    }
};
