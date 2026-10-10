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
        Schema::table('projets', function (Blueprint $table) {
            $table->unsignedBigInteger('clients_id')->after('id');

            $table->foreign('clients_id')
            ->references('id')
            ->on('clients')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projets', function (Blueprint $table) {
             // Supprimer la clé étrangère
             $table->dropForeign(['clients_id']);

             // Supprimer la colonne client_id
             $table->dropColumn('clients_id');
  });
      
    }
};
