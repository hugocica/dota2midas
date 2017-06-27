<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserInformationToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->text("profileurl");
            $table->integer("personastate");
            $table->text("communityvisibilitystate");
            $table->text("profilestate");
            $table->date("lastlogoff");
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
            //
            $table->dropColumn("profileurl");
            $table->dropColumn("personaname");
            $table->dropColumn("personastate");
            $table->dropColumn("communityvisibilitystate");
            $table->dropColumn("profilestate");
            $table->dropColumn("lastlogoff");
        });
    }
}
