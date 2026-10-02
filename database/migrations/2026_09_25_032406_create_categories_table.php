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
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Contoh: Makanan & Minuman, Fotokopi, Pulsa, dll
        $table->string('slug')->unique();
        $table->enum('type', ['physical', 'service'])->default('physical'); // fisik (ada stok) vs jasa
        $table->timestamps();
    });
}
};
