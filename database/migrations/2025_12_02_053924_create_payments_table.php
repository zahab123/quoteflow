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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignid('quotation_id')->constrained()->onDelete('cascade');
        $table->decimal('amount', 10, 2);
        $table->string('payment_method')->nullable(); // cash, bank, easypaisa, jazzcash
        $table->string('status')->default('paid');    // paid or refunded
        $table->timestamps();

    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
