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
        Schema::create('users', function (Blueprint $table) {
            $table->id();                                        // Crea una columna 'id' autoincrementable
            $table->string  ('name',            100);            // Crea una columna 'name' de 100 caracteres
            $table->string  ('surname',         100);            // Crea una columna 'surname' de 100 caracteres
            $table->string  ('username',        100)->unique();  // Crea una columna 'username' única de 100 caracteres
            $table->string  ('email',           100)->unique();  // Crea una columna 'email' única de 100 caracteres
            $table->char    ('sex',             1);
            $table->date    ('date_of_birth');                   // Crea una columna 'date_of_birth' de tipo DATE
            $table->string  ('phone_number',    100);            // Crea una columna 'phone_number' de 100 caracteres
            $table->string  ('password');                        // Crea una columna 'password'
            $table->integer ('tokens')              ->default(0);// Crea una columna 'tokens' con valor predeterminado 0
            $table->string  ('profile_pic')         ->nullable();  // Crea una columna 'profile_pic' que puede tener valor nulo.
            $table->timestamps();                                // Crea las columnas 'created_at' y 'updated_at'
        });

        // Tabla para los tokens de restablecimiento de contraseña
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();  // Columna 'email' como clave primaria
            $table->string('token');  // Columna 'token'
            $table->timestamp('created_at')->nullable();  // Columna 'created_at' para la fecha de creación del token
        });

        // Tabla para las sesiones de usuario
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();  // Columna 'id' como clave primaria
            $table->foreignId('user_id')->nullable()->index();  // Columna 'user_id' como clave foránea
            $table->string('ip_address', 45)->nullable();  // Columna 'ip_address' para dirección IP
            $table->text('user_agent')->nullable();  // Columna 'user_agent' para el agente de usuario
            $table->longText('payload');  // Columna 'payload' para la carga útil
            $table->integer('last_activity')->index();  // Columna 'last_activity' con índice
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
