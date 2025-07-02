<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');     // l’utilisateur qui envoie
            $table->unsignedBigInteger('receiver_id');   // l’utilisateur qui reçoit
            $table->boolean('accepted')->default(false);   // accepté = true, sinon false
            $table->timestamps();

            // Relations (optionnel si pas encore de contraintes)
            $table->foreign('sender_id')->references('id')->on('utilisateurs')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('utilisateurs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
