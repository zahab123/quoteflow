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
            $table->foreignid('quotation_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['sent', 'viewed', 'accepted', 'declined']); 
            $table->dateTime('changed_at'); 
            $table->text('remarks')->nullable(); 
            $table->timestamps(); 
           
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
