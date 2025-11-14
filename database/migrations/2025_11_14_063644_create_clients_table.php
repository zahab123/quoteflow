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
        Schema::create('clients', function (Blueprint $table) {
            $table->id(); 
           // $table->unsignedBigInteger('id'); //
            $table->string('name'); 
            $table->string('company'); 
            $table->string('email'); 
            $table->string('phone'); 
            $table->text('address'); 
            $table->text('notes')->nullable(); 
            $table->timestamps(); 

            
           // $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
