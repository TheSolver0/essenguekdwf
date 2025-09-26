<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up()
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('prenom');
            $table->string('nom');
            $table->string('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->string('region')->nullable();
            $table->string('zip')->nullable();
            $table->string('email');
            $table->string('telephone')->nullable();
            $table->text('message');
            $table->boolean('lu')->default(false); // Pour suivi de lecture
            $table->timestamps();
        });
    }
};
