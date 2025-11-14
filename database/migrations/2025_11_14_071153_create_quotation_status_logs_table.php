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
        Schema::create('quotation_status_logs', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('quotation_id'); 
            $table->enum('status', ['sent', 'viewed', 'accepted', 'declined']); 
            $table->dateTime('changed_at'); 
            $table->text('remarks')->nullable(); 
            $table->timestamps(); 

            
            $table->foreign('quotation_id')->references('id')->on('quotations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_status_logs');
    }
};
