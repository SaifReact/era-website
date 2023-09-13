<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('password');
            $table->string('first_name')->nullable()->after('photo');
            $table->string('last_name')->nullable()->after('first_name');
            $table->boolean('send_notification')
                ->nullable(false)
                ->default(false)
                ->after('last_name');
            $table->boolean('reserved')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('photo');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('send_notification');
        });
    }
}
