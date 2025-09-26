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
        Schema::table('users', function (Blueprint $table) {
            $table->string('badge')->nullable()->after('photo');
            $table->decimal('total_dons', 12, 2)->default(0)->after('badge');
            $table->integer('total_likes')->default(0)->after('total_dons');
            $table->integer('total_commentaires')->default(0)->after('total_likes');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['badge', 'total_dons', 'total_likes', 'total_commentaires']);
        });
    }

};
