<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDeclinedColumnInStudentCourseRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_course_requests', function (Blueprint $table) {
            $table->boolean('isDeclined')->default(0);
            $table->string('declined_reason')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_course_requests', function (Blueprint $table) {
            if (Schema::hasColumns('student_course_requests', ['isDeclined', 'declined_reason'])) {
                $table->dropColumn('isDeclined');
                $table->dropColumn('declined_reason');
            }
        });
    }
}
