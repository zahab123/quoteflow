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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('id'); 
            $table->unsignedBigInteger('id'); 
            $table->string('title'); 
            $table->decimal('total', 15, 2); 
            $table->decimal('tax', 15, 2); 
            $table->decimal('discount', 15, 2); 
            $table->enum('status', ['draft', 'sent', 'viewed', 'accepted', 'declined'])->default('draft'); // Current status
            $table->string('pdf_path')->nullable();
            $table->dateTime('sent_at')->nullable(); 
            $table->dateTime('viewed_at')->nullable();
            $table->dateTime('accepted_at')->nullable();
            $table->dateTime('declined_at')->nullable();
            $table->timestamps(); 

            
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
