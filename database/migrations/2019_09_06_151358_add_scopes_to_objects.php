<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScopesToObjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('objects', function (Blueprint $table) {
            $table->boolean('only_auth')->default(false);
            $table->boolean('price_admins_only')->default(false);
            $table->boolean('object_admins_only')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('objects', function (Blueprint $table) {
            $table->dropColumn('only_auth');
            $table->dropColumn('price_admins_only');
            $table->dropColumn('object_admins_only');
        });
    }
}
