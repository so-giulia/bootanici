<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //aggiunta a tabella esistente creata da auth
            $table->string('last_name', 60)->after('name');
            $table->string('slug')->unique()->after('last_name');
            $table->string('address', 100)->after('remember_token');
            $table->string('cap', 5)->after('address');
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
            $table->dropColumn(['last_name', 'address', 'cap']);
            
        });
    }
}
