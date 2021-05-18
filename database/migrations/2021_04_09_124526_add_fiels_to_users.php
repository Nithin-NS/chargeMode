<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFielsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::table('users', function($table) {
                $table->string('mobile');
            });
            Schema::table('users', function($table) {
                $table->string('address');
            });
            Schema::table('users', function($table) {
                $table->integer('pin');
            });
            Schema::table('users', function($table) {
                $table->string('state');
            });
            Schema::table('users', function($table) {
                $table->string('district');
            });
            Schema::table('users', function($table) {
                $table->string('status');
            });
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
            Schema::table('users', function($table) {
                $table->dropColumn('mobile');
            });
            Schema::table('users', function($table) {
                $table->dropColumn('address');
            });
            Schema::table('users', function($table) {
                $table->dropColumn('pin');
            });
            Schema::table('users', function($table) {
                $table->dropColumn('state');
            });
            Schema::table('users', function($table) {
                $table->dropColumn('district');
            });
            Schema::table('users', function($table) {
                $table->dropColumn('status');
            });
        });
    }
}
