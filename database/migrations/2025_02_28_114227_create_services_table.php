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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId   ('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string      ('title', 75);
            $table->string      ('description');
            $table->integer     ('price');
            $table->string      ('image')->nullable();
            $table->integer     ('stock');
            $table->string      ('category')->nullable();
            $table->char        ('contact', 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
