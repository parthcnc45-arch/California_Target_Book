<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classified_rates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rate');
            $table->decimal('rate_amount', 10, 2);
            $table->string('type');
            $table->timestamps();
        });

        // Seed default rates
        DB::table('classified_rates')->insert([
            [
                'name' => '$165/week',
                'rate' => '$165/wk',
                'rate_amount' => 165.00,
                'type' => 'weekly',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '$585/month',
                'rate' => '$585/mo',
                'rate_amount' => 585.00,
                'type' => 'monthly',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classified_rates');
    }
};
