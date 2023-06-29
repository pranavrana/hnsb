<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\LogOptions;
// use Spatie\Activitylog\Contracts\Activity;
// use App\Traits\Activitylog;

class GeneralSetting extends Model
{
    use HasFactory,SoftDeletes;//, LogsActivity, Activitylog;
    
        /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'general_setting_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'label',
        'key',
        'value',
        'is_default',
        'status'
    ];

//     public function getActivitylogOptions(): LogOptions
//     {
//         return LogOptions::defaults()
//             ->logOnly(['label', 'value', 'is_default', 'status'])
//             ->useLogName('General Settings')
//             ->logOnlyDirty()
//             ->dontSubmitEmptyLogs();
//         // Chain fluent methods for configuration options
//     }
// 
//     public function tapActivity(Activity $activity, string $eventName)
//     {
//         $generalSettingName = "";
// 
//         if ($eventName == "updated") {
//             $generalSettingName = GeneralSetting::where('general_setting_id', $activity->subject_id)->pluck('label')->first();
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
//         if (isset($activity->properties[$isAttrOrOld]['Label'])) {
//             $generalSettingName = $activity->properties[$isAttrOrOld]['Label'];
//         }
// 
//         $activity->description = "General Settings " . $generalSettingName . " Information has been " . $eventName;
//     }
}
