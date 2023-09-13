<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_infos', function (Blueprint $table) {
            $table->id();
            $table->string('logo_src');
            $table->string('logo_small_src');
            $table->text('logo_alt');
            $table->string('root_url');
            $table->text('website_name');
            $table->text('tagline')->nullable();
            $table->string('fax')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('web')->nullable();
            $table->text('facebook')->nullable();
            $table->text('linkedin')->nullable();
            $table->text('company_summary')->nullable();
            $table->string('open_days')->nullable();
            $table->string('duration')->nullable();

            $table->timestamps();
        });

        // Insert some production data
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_infos');
    }
}
