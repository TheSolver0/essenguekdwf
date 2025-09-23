<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('medias', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->enum('category', ['photo','video','rapport'])->default('photo'); // classification visible
            $table->string('media_url'); // chemin /storage/...
            $table->string('implantation')->nullable(); // ex: "Douala", "Yaoundé"
            $table->date('date_publication')->nullable(); // date de publication/affichage
            $table->date('date_expiration')->nullable(); // publication + 80 jours par défaut
            $table->boolean('archived')->default(false);
            $table->text('notes')->nullable(); // infos admin
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('medias');
    }
};
