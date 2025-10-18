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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nomor_induk');
            $table->string('name', 100);
            $table->enum('gender', ['L', 'P']);
            $table->string('birth_place', 100)->nullable();
            $table->date('birthday')->nullable();
            $table->string('parent', 100)->nullable();
            $table->integer('room_id')->unsigned()->nullable();
            $table->enum('status', ['Aktif', 'Lulus', 'Pindah'])->default('Aktif');
            $table->string('pin', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
