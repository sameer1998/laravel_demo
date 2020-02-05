<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_devices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('deviceToken');
            $table->string('deviceType');
            $table->timestamp('created');
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
         Schema::dropIfExists('user_devices');
    }
}
