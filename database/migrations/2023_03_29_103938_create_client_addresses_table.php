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
        Schema::create('client_addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('area_id')->unsigned();
            $table->string('street_name');
            $table->string('build_no');
            $table->string('floor_no');
            $table->string('flat_no');
            $table->boolean('is_main');
            $table->bigInteger('client_id')->unsigned();

            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('client_id')->references('national_id')->on('clients');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_addresses');
    }
};
