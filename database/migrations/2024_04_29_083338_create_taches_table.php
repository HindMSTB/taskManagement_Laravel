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
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->longText('description');
            $table->date('dateDue')->nullable();
            $table->string('createdBy')->nullable();
            $table->string('modifiedBy')->nullable();
            $table->string('deletedBy')->nullable();
            $table->timestamp('dateCreation')->useCurrent();
            $table->timestamp('dateModification')->nullable();
            $table->timestamp('dateSuppression')->nullable();
            $table->string('etat')->default('en cours');
            $table->string('priorite')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('user_id'); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
