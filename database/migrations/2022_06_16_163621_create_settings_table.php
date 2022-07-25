<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string("store_name", 50)->unique()->nullable();
            $table->string("store_logo", 255)->nullable();
            $table->string("store_currency", 255)->nullable();
            $table->string("home_title", 255)->nullable();
            $table->string("whatsapp_phone", 50)->nullable();
            $table->string("contact_phone1", 50)->nullable();
            $table->string("contact_phone2", 50)->nullable();
            $table->string("contact_address", 100)->nullable();
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
        Schema::dropIfExists('settings');
    }
}
