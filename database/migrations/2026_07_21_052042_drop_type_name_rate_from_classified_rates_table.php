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
        // 1. Copy 'name' to 'title' where 'title' is NULL
        if (Schema::hasColumn('classified_rates', 'name') && Schema::hasColumn('classified_rates', 'title')) {
            DB::statement("UPDATE classified_rates SET title = name WHERE title IS NULL OR title = ''");
        }

        // 2. Drop columns name, rate, type
        Schema::table('classified_rates', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('classified_rates', 'name')) {
                $columnsToDrop[] = 'name';
            }
            if (Schema::hasColumn('classified_rates', 'rate')) {
                $columnsToDrop[] = 'rate';
            }
            if (Schema::hasColumn('classified_rates', 'type')) {
                $columnsToDrop[] = 'type';
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
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
            $table->string('name')->nullable();
            $table->string('rate')->nullable();
            $table->string('type')->nullable();
        });
    }
};
