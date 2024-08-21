<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mensajes', function (Blueprint $table) {
            $table->unsignedBigInteger('receiver_id')->nullable()->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('mensajes', function (Blueprint $table) {
            $table->dropColumn('receiver_id');
        });
    }
};

