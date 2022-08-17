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
        Schema::create('infractions', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->double('longitude', 10, 6);
            $table->double('latitude', 10, 6);
            $table->double('height', 10, 6);
            $table->double('velocity', 10, 6);
            // $table->foreignId('image_id')->constrained('images')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained('vehicles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infractions');
    }
};
