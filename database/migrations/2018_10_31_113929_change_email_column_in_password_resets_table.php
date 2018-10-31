<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeEmailColumnInPasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('password_resets', function(Blueprint $table) {
            $table->dropColumn('email');
            $table->increments('id')->first();
            $table->unsignedInteger('user_id')->after('id');
            $table->foreign('user_id')
                ->on('users')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('password_resets', function(Blueprint $table) {
            $table->dropColumn('id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->string('email')->index()->first();
        });
    }
}
