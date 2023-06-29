<?php

namespace App\Models;

// use App\Traits\Activitylog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\LogOptions;
// use Spatie\Activitylog\Contracts\Activity;

class AcademicYear extends Model
{
    use HasFactory, SoftDeletes;//, LogsActivity, Activitylog;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'academic_year_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'year',
        'is_default'
    ];

//     public function getActivitylogOptions(): LogOptions
//     {
//         return LogOptions::defaults()
//             ->logOnly(['year', 'is_default'])
//             ->useLogName('Academic Year')
//             ->logOnlyDirty()
//             ->dontSubmitEmptyLogs();
//         // Chain fluent methods for configuration options
//     }
// 
//     public function tapActivity(Activity $activity, string $eventName)
//     {
//         $academicYearName = "";
// 
//         if ($eventName == "updated") {
//             $academicYearName = AcademicYear::where('academic_year_id', $activity->subject_id)->pluck('year')->first();
//         }
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
//         $isAttrOrOld = ($eventName == "created" || $eventName == "deleted") ? (($eventName == "created") ? "attributes" : "old") : "attributes";
// 
//         if (isset($activity->properties[$isAttrOrOld]['Year'])) {
//             $academicYearName = $activity->properties[$isAttrOrOld]['Year'];
//         }
// 
//         $activity->description = "Academic Year " . $academicYearName . " Information has been " . $eventName;
//     }
}
