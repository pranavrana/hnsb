<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\StudentEnrollment;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = 'login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'name' => ['required', 'string', 'max:255'],
            'student_name' => ['required', 'string', 'max:255'],
            'father_name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contact_no' => ['required','max:255'],
            'marksheet_no' => ['required', 'string', 'max:255','alpha_num', 'unique:users,marksheet_no_12'],
            'confirm_password' => ['required', 'string', 'min:8'],
            'course' => ['required'],
            'semester' => ['required'],
            // 'group' => ['required'],
            'address' => ['required', 'string', 'max:255'],
            'cur_city' => ['required', 'string', 'max:255'],
            'cur_taluko' => ['required', 'string', 'max:255'],
            'cur_district' => ['required', 'string', 'max:255'],
            'cur_pincode' => ['required', 'string', 'max:255'],
        ],
        [
            'student_name.required' => 'Please enter student name.',
            'father_name.required' => 'Please enter father name.',
            'surname.required' => 'Please enter surname.',
            'email.required' => 'Please enter email.',
            'contact_no.required' => 'Please enter contact no.',
            'marksheet_no.required' => 'Please enter marksheet no.',
            'marksheet_no.unique' => 'Marksheet no already registered.',
            'confirm_password.required' => 'Please enter password.',
            'course.required' => 'Please select course.',
            'semester.required' => 'Please select semester.',
            // 'group.required' => 'Please select group.',
            'address.required' => 'Please enter current address.',
            'cur_city.required' => 'Please enter current city.',
            'cur_taluko.required' => 'Please enter current taluko.',
            'cur_district.required' => 'Please enter current district.',
            'cur_pincode.required' => 'Please enter current pincode.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['student_name']. ' ' .$data['father_name']. ' '.$data['surname'],
            'student_name' => $data['student_name'],
            'father_name' => $data['father_name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'contact_no' => $data['contact_no'],
            'marksheet_no_12' => $data['marksheet_no'],
            'password' => Hash::make($data['password']),
            'address' => $data['address'],
            'cur_city' => $data['cur_city'],
            'cur_taluko' => $data['cur_taluko'],
            'cur_district' => $data['cur_district'],
            'cur_pincode' => $data['cur_pincode'],
        ]);
        
        $acedemicYear = AcademicYear::where('is_default', 1)->first();
        $enrollment = StudentEnrollment::create([
            'academic_year_id' => $acedemicYear->academic_year_id,
            'course_id' => $data['course'] ?? 0,
            'semester_id' => $data['semester'] ?? 0,
            'group_id' => $data['group'] ?? NULL,
            'user_id' => $user->id
        ]);
        Session::flash('success', 'Registered successfully! Please verify email.');
        return $user;
    }
}
