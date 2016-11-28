<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     * "season_id", "area_id", "business_id", "customer_id", "event_date", "quantity", "advance", "completed"
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('season_id');
            $table->integer('area_id');
            $table->integer('business_id');
            $table->integer('customer_id');
            $table->timestamp('event_date');
            $table->float('quantity');
            $table->float('completed')->default(0);
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
        Schema::drop('schedules');
    }
}
