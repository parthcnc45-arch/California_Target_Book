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
        Schema::table('classified_rates', function (Blueprint $table) {
            if (!Schema::hasColumn('classified_rates', 'title')) {
                $table->string('title')->nullable()->after('id');
            }
            if (!Schema::hasColumn('classified_rates', 'days')) {
                $table->integer('days')->nullable()->after('rate_amount');
            }
            if (!Schema::hasColumn('classified_rates', 'status')) {
                $table->string('status')->default('Show')->after('days');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classified_rates', function (Blueprint $table) {
            $table->dropColumn(['title', 'days', 'status']);
        });
    }
};
