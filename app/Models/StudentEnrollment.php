<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\LogOptions;
// use Spatie\Activitylog\Contracts\Activity;
// use App\Traits\Activitylog;

class StudentEnrollment extends Model
{
    use HasFactory;//, LogsActivity, Activitylog;

    protected $primaryKey = 'enrollment_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'academic_year_id',
        'course_id',
        'semester_id',
        'group_id',
        'user_id',
        'is_fees_paid',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'academic_year_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'semester_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function paidFee()
    {
        return $this->hasOne(PaidFees::class, 'enrollment_id', 'enrollment_id');
    }

    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //         ->logOnly(['academic_year_id', 'course_id', 'semester_id', 'group_id', 'user_id', 'roll_no', 'is_fees_paid'])
    //         ->useLogName('Admin')
    //         ->logOnlyDirty()
    //         ->dontSubmitEmptyLogs();
    //     // Chain fluent methods for configuration options
    // }
}
