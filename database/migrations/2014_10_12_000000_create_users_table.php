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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('createdBy')->default('inscription');
            $table->string('modifiedBy')->nullable();
            $table->string('deletedBy')->nullable();
            $table->timestamp('dateCreation')->useCurrent();
            $table->timestamp('dateModification')->nullable();
            $table->timestamp('dateSuppression')->nullable();
            $table->string('usertype')->default('user');
            $table->string('status')->default(1);
            $table->string('adresse');
            $table->string('num');
            $table->date('dateNaissance')->nullable();  
            $table->rememberToken();
            $table->timestamps();


    
    });
     
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
