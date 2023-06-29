<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\LogOptions;
// use Spatie\Activitylog\Contracts\Activity;
// use App\Traits\Activitylog;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable; //, LogsActivity, Activitylog;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'student_name',
        'father_name',
        'surname',
        'contact_no',
        'marksheet_no_12',
        'address',
        'admission_rejection_reason',
        'is_admission_approved',
        'obtained_marks',
        'passing_year',
        'exam_center',
        'leaving_date',
        'join_date',
        'school_name',
        'student_sign',
        'student_photo',
        'aadhar_card_no',
        'caste',
        'birth_date',
        'gender',
        'is_form_fees_paid',
        'is_completed_registration',
        'is_initial_college_fees_paid',
        'admission_processed_at',
        'admission_processed_by',
        'address',
        'cur_city',
        'cur_taluko',
        'cur_district',
        'cur_pincode',
        'per_address',
        'per_city',
        'per_taluko',
        'per_district',
        'per_pincode',
        'cancellation_note',
        'cancelled_at',
        'cancelled_by',
        'is_cancelled',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function enrollment()
    {
        return $this->hasMany(StudentEnrollment::class, 'user_id', 'id');
    }
    
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }

    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //         ->logOnly(['name', 'email', 'student_name', 'father_name', 'surname', 'contact_no', 'marksheet_no_12', 'address', 'admission_rejection_reason', 'is_admission_approved', 'obtained_marks', 'passing_year', 'exam_center', 'leaving_date', 'join_date', 'school_name', 'student_sign', 'student_photo', 'aadhar_card_no', 'caste', 'birth_date', 'gender', 'is_form_fees_paid', 'is_completed_registration', 'is_initial_college_fees_paid', 'admission_processed_at', 'admission_processed_by', 'address', 'cur_city', 'cur_taluko', 'cur_district', 'cur_pincode', 'per_address', 'per_city', 'per_taluko', 'per_district', 'per_pincode'])
    //         ->useLogName('Student')
    //         ->logOnlyDirty()
    //         ->dontSubmitEmptyLogs();
    //     // Chain fluent methods for configuration options
    // }

    // public function tapActivity(Activity $activity, string $eventName)
//     {
//         $studentName = "";
// 
//         if ($eventName == "updated") {
//             $studentName = User::where('id', $activity->subject_id)->pluck('name')->first();
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
//             $studentName = $activity->properties[$isAttrOrOld]['Name'];
//         }
// 
//         $activity->description = "Student " . $studentName . " Information has been " . $eventName;
//     }
}
