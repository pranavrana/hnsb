<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmissionFee extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'admission_fees_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "academic_year_id",
        "course_id", 
        "semester_id", 
        "admission_fees", 
        "cutoff_date"
    ];

    public function academic_year()
    {
        return $this->hasOne(AcademicYear::class,'academic_year_id','academic_year_id');
    }

    public function course()
    {
        return $this->hasOne(Course::class,'course_id','course_id');
    }
    
    public function semester()
    {
        return $this->hasOne(Semester::class,'semester_id','semester_id');
    }

}
