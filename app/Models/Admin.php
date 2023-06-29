<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\LogOptions;
// use Spatie\Activitylog\Contracts\Activity;
// use App\Traits\Activitylog;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles;//,  LogsActivity, Activitylog;

    protected $guard = "admin";

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'admin_id';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];


//     public function getActivitylogOptions(): LogOptions
//     {
//         return LogOptions::defaults()
//             ->logOnly(['name', 'email', 'profile_image'])
//             ->useLogName('Admin')
//             ->logOnlyDirty()
//             ->dontSubmitEmptyLogs();
//         // Chain fluent methods for configuration options
//     }
// 
//     public function tapActivity(Activity $activity, string $eventName)
//     {
//         $adminName = "";
// 
//         if ($eventName == "updated") {
//             $adminName = Admin::where('admin_id', $activity->subject_id)->pluck('name')->first();
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
//         if (isset($activity->properties[$isAttrOrOld]['Name'])) {
//             $adminName = $activity->properties[$isAttrOrOld]['Name'];
//         }
// 
//         $activity->description = "Admin " . $adminName . " Information has been " . $eventName;
//     }
}
