<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\LogOptions;
// use Spatie\Activitylog\Contracts\Activity;
// use App\Traits\Activitylog;

class Semester extends Model
{
    use HasFactory, SoftDeletes; //, LogsActivity, Activitylog;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'semester_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'semester_name',
    ];
    
    public function course()
    {
        return $this->hasOne(Course::class,'course_id','course_id');
    }

    public function groups()
    {
        return $this->hasMany(Group::class,'semester_id');
    }

//     public function getActivitylogOptions(): LogOptions
//     {
//         return LogOptions::defaults()
//             ->logOnly(['course_id','semester_name'])
//             ->useLogName('Semester')
//             ->logOnlyDirty()
//             ->dontSubmitEmptyLogs();
//         // Chain fluent methods for configuration options
//     }
// 
//     public function tapActivity(Activity $activity, string $eventName)
//     {
//         $semesterName = "";
// 
//         if ($eventName == "updated") {
//             $semesterName = Semester::where('semester_id', $activity->subject_id)->pluck('semester_name')->first();
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
//         if (isset($activity->properties[$isAttrOrOld]['Semester Name'])) {
//             $semesterName = $activity->properties[$isAttrOrOld]['Semester Name'];
//         }
// 
//         $activity->description = "Semester " . $semesterName . " Information has been " . $eventName;
//     }

}
