<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\LogOptions;
// use Spatie\Activitylog\Contracts\Activity;
// use App\Traits\Activitylog;

class Group extends Model
{
    use HasFactory, SoftDeletes;//, LogsActivity, Activitylog;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'group_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'semester_id',
        'group_name',
        'range_for_roll_no',
        'combination_code'
    ];
    
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'semester_id');
    }

//     public function getActivitylogOptions(): LogOptions
//     {
//         return LogOptions::defaults()
//             ->logOnly(['course_id','semester_id','group_name','range_for_roll_no'])
//             ->useLogName('Group')
//             ->logOnlyDirty()
//             ->dontSubmitEmptyLogs();
//         // Chain fluent methods for configuration options
//     }
// 
//     public function tapActivity(Activity $activity, string $eventName)
//     {
//         $groupName = "";
// 
//         if ($eventName == "updated") {
//             $groupName = Group::where('group_id', $activity->subject_id)->pluck('group_name')->first();
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
//         if (isset($activity->properties[$isAttrOrOld]['Group Name'])) {
//             $groupName = $activity->properties[$isAttrOrOld]['Group Name'];
//         }
// 
//         $activity->description = "Group " . $groupName . " Information has been " . $eventName;
//     }
}
