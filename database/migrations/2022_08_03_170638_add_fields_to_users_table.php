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
            $table->string('surname')->nullable()->after('name');
            $table->string('father_name')->nullable()->after('name');
            $table->string('student_name')->nullable()->after('name');
            $table->text('address')->nullable()->after('email');
            $table->string('contact_no', 25)->nullable()->after('email');
            $table->string('marksheet_no_12')->nullable()->after('email');
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
            $table->dropColumn('surname');
            $table->dropColumn('father_name');
            $table->dropColumn('student_name');
            $table->dropColumn('address');
            $table->dropColumn('contact_no');
            $table->dropColumn('marksheet_no_12');
        });
    }
};
