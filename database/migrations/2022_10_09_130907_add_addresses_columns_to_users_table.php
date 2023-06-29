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
        Schema::table('users', function (Blueprint $table) {
            // $table->renameColumn('address', 'cur_address');
            $table->string('cur_city')->nullable()->after('address');
            $table->string('cur_taluko')->nullable()->after('cur_city');
            $table->string('cur_district')->nullable()->after('cur_taluko');
            $table->string('cur_pincode')->nullable()->after('cur_district');

            $table->string('per_address')->nullable()->after('cur_pincode');
            $table->string('per_city')->nullable()->after('per_address');
            $table->string('per_taluko')->nullable()->after('per_city');
            $table->string('per_district')->nullable()->after('per_taluko');
            $table->string('per_pincode')->nullable()->after('per_district');
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
            // $table->renameColumn('cur_address', 'address');
            $table->dropColumn('cur_city');
            $table->dropColumn('cur_taluko');
            $table->dropColumn('cur_district');
            $table->dropColumn('cur_pincode');
            $table->dropColumn('per_address');
            $table->dropColumn('per_city');
            $table->dropColumn('per_taluko');
            $table->dropColumn('per_district');
            $table->dropColumn('per_pincode');
        });
    }
};
