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
        Schema::create('air_duct_cleaning', function (Blueprint $table) {
            $table->id();
            $table->enum('num_furnace', ['1', '2', '3+']);
            $table->integer('square_footage_min');
            $table->integer('square_footage_max');
            $table->integer('furnace_loc_sidebyside');
            $table->integer('furnace_loc_different');
            $table->integer('final_price');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('air_duct_cleaning');
    }
};
