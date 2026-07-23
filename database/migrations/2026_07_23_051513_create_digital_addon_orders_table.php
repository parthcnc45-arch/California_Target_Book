<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital_addon_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('transaction_id')->nullable();
            $table->string('item_name');
            $table->integer('amount'); // in cents
            $table->string('payment_status')->default('Paid'); // Paid, Refunded
            $table->string('delivery_status')->default('Sent'); // Sent, Failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('digital_addon_orders');
    }
};
