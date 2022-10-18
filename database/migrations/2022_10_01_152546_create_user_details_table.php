<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('residence')->nullable();
            $table->string('phone')->nullable();
            $table->string('language', 25)->nullable();
            //curare aspetto pagamenti 
            $table->string('paypal')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //posso non demolire anche la relazione se onDelete set null;
        //$table->dropForeign('users_user_detail_id_foreign');

        Schema::dropIfExists('user_details');
    }
}