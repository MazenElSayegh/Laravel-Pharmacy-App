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
        Schema::create('pharmacies_medicines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('medicine_id')->unsigned();
            $table->bigInteger('pharmacy_id')->unsigned();
            $table->unique([ 'pharmacy_id','medicine_id']);
            $table->foreign('pharmacy_id')->references('id')->on('pharmacies');
            $table->foreign('medicine_id')->references('id')->on('medicines');
            $table->unsignedInteger('quantity');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacies_medicines');
    }
};
