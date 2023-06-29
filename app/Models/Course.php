<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\LogOptions;
// use Spatie\Activitylog\Contracts\Activity;
// use App\Traits\Activitylog;

class Course extends Model
{
    use HasFactory, SoftDeletes; //, LogsActivity, Activitylog;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'course_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_name',
    ];
    
//     public function getActivitylogOptions(): LogOptions
//     {
//         return LogOptions::defaults()
//             ->logOnly(['course_name'])
//             ->useLogName('Course')
//             ->logOnlyDirty()
//             ->dontSubmitEmptyLogs();
//         // Chain fluent methods for configuration options
//     }
// 
//     public function tapActivity(Activity $activity, string $eventName)
//     {
//         $couseName = "";
// 
//         if ($eventName == "updated") {
//             $couseName = Course::where('course_id', $activity->subject_id)->pluck('course_name')->first();
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
//         if (isset($activity->properties[$isAttrOrOld]['Course Name'])) {
//             $couseName = $activity->properties[$isAttrOrOld]['Course Name'];
//         }
// 
//         $activity->description = "Course " . $couseName . " Information has been " . $eventName;
//     }

    public function semesters(){
        return $this->hasMany(Semester::class,'semester_id');
    }
}
