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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            
            // User and Subscription Relationship
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('subscription_id')->nullable()->index();
            
            // Stripe Identifiers
            $table->string('stripe_charge_id')->unique()->nullable();
            $table->string('stripe_invoice_id')->nullable()->index();
            
            // Payment Details
            $table->string('description')->nullable();
            $table->string('plan')->nullable();
            $table->integer('amount'); // in cents
            $table->integer('amount_refunded')->default(0); // in cents
            
            // Status and Metadata
            $table->string('status');
            $table->string('payment_method')->nullable();
            $table->string('invoice_url')->nullable();
            $table->text('raw_stripe_data')->nullable();
            
            // Timestamps
            $table->timestamp('transaction_date')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
