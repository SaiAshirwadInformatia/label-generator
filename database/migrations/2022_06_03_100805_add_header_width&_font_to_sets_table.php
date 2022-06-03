<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sets', function (Blueprint $table) {
            $table->unsignedSmallInteger('header_width')->default('30')->after('limit');
            $table->unsignedSmallInteger('header_font')->default('12')->after('header_width');
        });
        \App\Models\Set::query()->update(['header_width' => 30, 'header_font' => 12]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sets', function (Blueprint $table) {
            $table->dropColumn(['header_width', 'header_font']);
        });
    }
};
