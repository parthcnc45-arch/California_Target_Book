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
        Schema::create('classifieds', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('Pending');
            $table->string('category')->default('Jobs');
            $table->string('organization_name');
            $table->string('title');
            $table->text('body');
            $table->string('link_url')->nullable();
            $table->date('starts_on');
            $table->date('ends_on');
            $table->string('advertiser_email');
            $table->string('rate')->nullable();
            $table->text('admin_notes')->nullable();
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
        Schema::dropIfExists('classifieds');
    }
};
