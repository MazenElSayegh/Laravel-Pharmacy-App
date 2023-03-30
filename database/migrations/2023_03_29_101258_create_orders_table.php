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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_insured');
            $table->unsignedInteger('status');
            $table->unsignedBigInteger('total_price');
            $table->string('prescription_image')->nullable();
            $table->string('creator_type');
            $table->timestamps();
           
            $table->bigInteger('doctor_id')->unsigned();
            $table->bigInteger('client_id')->unsigned();

            $table->foreign('client_id')->references('id')->on('clients');
   
            $table->foreign('doctor_id')->references('national_id')->on('doctors');
        });
    }

    /**
     * Reverse the migrations.
     */
    // public function down(): void
    // {
    //     Schema::dropIfExists('orders');
    // }
};
