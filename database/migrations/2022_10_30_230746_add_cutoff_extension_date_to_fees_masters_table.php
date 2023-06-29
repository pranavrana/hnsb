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
        Schema::table('fees_masters', function (Blueprint $table) {
            $table->string('cutoff_extension_date')->default(NULL)->nullable()->after('cutoff_date');
            $table->tinyInteger('cutoff_extension_status')->default(0)->after('cutoff_date')->comment('0 for Disable | 1 for Enable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fees_masters', function (Blueprint $table) {
            $table->dropColumn('cutoff_extension_date');
            $table->dropColumn('cutoff_extension_status');
        });
    }
};
