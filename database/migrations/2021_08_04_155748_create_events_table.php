<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('meta')->nullable();
            $table->string('thumbnail');
            $table->string('image');
            $table->timestamp('event_at');
            $table->text('teaser');
            $table->longText('detail');
            $table->tinyInteger('status')->nullable();
            $table->timestamp('publish_at')->nullable();


            /*$table->date('date_data');
            $table->dateTime('dateTime_data');
            $table->datetimeTz('datetimeTz_data');
            $table->time('time_data');
            $table->timeTz('timeTz_data');
            $table->timestamp('timestamp_data');*/

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
        Schema::dropIfExists('events');
    }
}
