<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAclFieldsPermissionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(\Config::get('fieldAcl.table'), function (Blueprint $table) {
            $table->char('model');
            $table->char('role');
            $table->text('hidden_fields');
            $table->text('updateable_fields');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(\Config::get('fieldAcl.table'));
    }

}
