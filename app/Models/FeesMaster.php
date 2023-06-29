<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\LogOptions;
// use Spatie\Activitylog\Contracts\Activity;
// use App\Traits\Activitylog;

class FeesMaster extends Model
{
    use HasFactory, SoftDeletes;//, LogsActivity, Activitylog;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'fees_master_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "academic_year_id", "course_id", "semester_id", "group_id", "gender", "fee_tut", "fee_lib", "fee_sport_gim", "fee_sport_clg", "fee_clgexam_stat", "fee_student_rahat", "fee_clg_dev", "fee_you_fas", "fee_med", "fee_hb_rasi", "fee_union", "fee_reg", "fee_enroll", "fee_icard", "fee_uniother", "fee_theal", "fee_lab", "fee_uni_exam_form", "fee_uniexam", "fee_comp", "fee_ele", "fee_other", "scope_exam_fee", "fee_late", "total_fee", "cutoff_date", "cutoff_extension_date", "cutoff_extension_status"
    ];

    public function academic_year()
    {
        return $this->hasOne(AcademicYear::class,'academic_year_id','academic_year_id');
    }

    public function semester()
    {
        return $this->hasOne(Semester::class,'semester_id','semester_id');
    }

    public function group()
    {
        return $this->hasOne(Group::class,'group_id','group_id');
    }

    public function course()
    {
        return $this->hasOne(Course::class,'course_id','course_id');
    }

//     public function getActivitylogOptions(): LogOptions
//     {
//         return LogOptions::defaults()
//             ->logOnly(["academic_year_id", "course_id", "semester_id", "group_id", "gender", "fee_tut", "fee_lib", "fee_sport_gim", "fee_sport_clg", "fee_clgexam_stat", "fee_student_rahat", "fee_clg_dev", "fee_you_fas", "fee_med", "fee_hb_rasi", "fee_union", "fee_reg", "fee_enroll", "fee_icard", "fee_uniother", "fee_theal", "fee_lab", "fee_uni_exam_form", "fee_uniexam", "fee_comp", "fee_ele", "fee_other", "scope_exam_fee", "fee_late", "total_fee"])
//             ->useLogName('Fees Master')
//             ->logOnlyDirty()
//             ->dontSubmitEmptyLogs();
//         // Chain fluent methods for configuration options
//     }
// 
//     public function tapActivity(Activity $activity, string $eventName)
//     {
// 
//         $attrValue = isset($activity->properties['attributes']) ? $activity->properties['attributes'] : array();
//         $oldValue = isset($activity->properties['old']) ? $activity->properties['old'] : array();
//         $activityLog = [];
//         if (!empty($attrValue)) {
//             $activityLog['attributes'] = $this->setActivityLogColumns($attrValue, $eventName);
//         }
// 
//         if (!empty($oldValue)) {
//             $activityLog['old'] = $this->setActivityLogColumns($oldValue, $eventName);
//         }
//         $activity->properties = $activityLog;
// 
//         $activity->description = "Fees Master Information has been " . $eventName;
//     }
}
