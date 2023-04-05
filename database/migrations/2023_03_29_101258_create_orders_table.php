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
            $table->enum('status', ['New', 'Processing', 'WaitingForUserConfirmation','Confirmed','Delivered','Canceled']);
            $table->unsignedBigInteger('total_price')->nullable();
            $table->string('prescription_image')->nullable();
            $table->string('creator_type');
            $table->timestamps();
           
            $table->bigInteger('doctor_id')->unsigned()->nullable();
            $table->bigInteger('client_id')->unsigned()->nullable();

            $table->foreign('client_id')->references('id')->on('clients');
   
            $table->foreign('doctor_id')->references('id')->on('doctors');
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
