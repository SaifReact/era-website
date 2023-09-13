<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_configs', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(false);
            $table->string('mailer');
            $table->string('host');
            $table->string('port');
            $table->string('username');
            $table->string('password');
            $table->string('encryption');
            $table->string('from_address');
            $table->string('from_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_configs');
    }
}
