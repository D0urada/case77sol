<?php
// database/migrations/xxxx_xx_xx_create_installation_types_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationTypesTable extends Migration
{
    public function up()
    {
        Schema::create('installation_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('installation_types');
    }
}
