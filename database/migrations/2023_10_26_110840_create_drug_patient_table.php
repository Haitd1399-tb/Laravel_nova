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
        Schema::create('drug_patient', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('patient_id')->unsigned();
            $table->unsignedBiginteger('drug_id')->unsigned();
            $table->bigInteger('price');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drug_patient');
    }
};
