<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editProfile()
    {
        return view('edit_account_info')->with(['userData' => Auth::guard('web')->user()]);
    }

    public function updateProfile(Request $request)
    {
        $profileImage = '';
        if ($request->hasFile('student_photo')) {
            $profileImage = 'student_photo_' . time() . '.' . $request->student_photo->extension();
            $request->student_photo->move(public_path('uploads/student_photo/'), $profileImage);
        } else {
            $profileImage = $request->old_image_path;
        }
        $user = User::where('id', $request->id)->update([
            'student_name' => $request['student_name'],
            'student_photo' => $profileImage,
        ]);

        if ($user) {
            $redirect = route('account');
            $arr = array("redirect" => $redirect);
            _json(200, 'Details updated successfully', $arr);
        } else {
            _json(201, 'Something went wrong plase try again!');
        }
    }

    public function changePassword(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'current_password' => ['required', new MatchOldPassword('web')],
                'new_password' => ['required', 'string', 'min:8'],
                'confirm_password' => ['required', 'string', 'min:8'],
            ],
            [
                'name.required' => 'Please enter name.'
            ]
        );

        if ($validator->fails()) {
            $return = '';
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                $return .= $message . "<br>";
            }

            _json(201, $return);
        } else {
            $user = User::where('id', $request->id)->update([
                'password' => Hash::make($request['confirm_password']),
            ]);

            if ($user) {
                $redirect = route('account');
                $arr = array("redirect" => $redirect);
                _json(200, 'Password changed successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }
}
