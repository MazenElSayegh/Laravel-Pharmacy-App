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
        Schema::create('medicines_orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();


            // $table->bigInteger('pharmacy_id')->unsigned();
            // $table->bigInteger('address_id')->unsigned();
            // $table->foreign('pharmacy_id')->references('national_id')->on('pharmacies');
            // $table->foreign('address_id')->references('id')->on('client_addresses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines_orders');
    }
};
