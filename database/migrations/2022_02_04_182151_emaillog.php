<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Emaillog extends Migration
{
    public function up()
    {
        // user_name (min 4, max 20), avatar (dimension: 256px x 256px), email, user_role (admin, user), registered_at, created_at, updated_a
        Schema::create('emaillog', function (Blueprint $table) {
            $table->id();
            $table->string('email_address');
            $table->text('body');
            $table->string('pin_code')->nullable();
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
        Schema::dropIfExists('emaillog');
    }
}
