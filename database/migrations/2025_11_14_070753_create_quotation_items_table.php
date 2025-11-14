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
        Schema::create('quotation_items', function (Blueprint $table) {
             $table->id(); 
            $table->unsignedBigInteger('id');
            $table->string('description'); 
            $table->integer('qty'); 
            $table->decimal('unit_price', 15, 2); 
            $table->decimal('tax', 8, 2); 
            $table->decimal('discount', 8, 2); 
            $table->decimal('total', 15, 2); 
            $table->timestamps(); 

            
            $table->foreign('id')->references('id')->on('quotations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_items');
    }
};
