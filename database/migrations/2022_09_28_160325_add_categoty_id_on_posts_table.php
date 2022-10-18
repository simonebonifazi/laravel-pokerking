<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategotyIdOnPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
           
            $table->unsignedBigInteger('category_id')->nullable()->after('id');
        //definisco la foreign key ('nome chiave') -> si riferisce alla colonna ('col') -> sulla tabella ('a cui ci riferiamo, sempre diversa da quella in cui siamo') 
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');//se qualcuno elimina la categoria, questa viene portata a null anzichè essere eliminati a cascata(default cascade)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            //speculare a up : prima elimino vincolo, poi colonna
            $table->dropForeign('posts_category_id_foreign');
            
            $table->dropColumn('category_id');
        });
    }
}