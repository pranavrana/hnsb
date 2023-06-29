<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaidFees extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "fees_master_id",
        "academic_year_id",
        "course_id",
        "semester_id",
        "group_id",
        "user_id",
        "enrollment_id",
        "transaction_id",
        "gender",
        "fee_tut",
        "fee_lib",
        "fee_sport_gim",
        "fee_sport_clg",
        "fee_clgexam_stat",
        "fee_student_rahat",
        "fee_clg_dev",
        "fee_you_fas",
        "fee_med",
        "fee_hb_rasi",
        "fee_union",
        "fee_reg",
        "fee_enroll",
        "fee_icard",
        "fee_uniother",
        "fee_theal",
        "fee_lab",
        "fee_uni_exam_form",
        "fee_uniexam",
        "fee_comp",
        "fee_ele",
        "fee_other",
        "scope_exam_fee",
        "fee_late",
        "total_fee",
        "is_late_fees_paid"
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'academic_year_id');
    }
    
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transaction(){
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }

    public function semester(){
        return $this->belongsTo(Semester::class, 'semester_id', 'semester_id');
    }

    public function course(){
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function group(){
        return $this->belongsTo(Group::class, 'group_id', 'group_id');
    }

    public function studentEnrollment(){
        return $this->belongsTo(StudentEnrollment::class, 'enrollment_id', 'enrollment_id');
    }
}
