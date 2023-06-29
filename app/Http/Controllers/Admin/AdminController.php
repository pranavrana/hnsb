<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['add','insert']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['delete']]);
    }


    /**
     * Show the admin listing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $result = Admin::orderBy('admin_id', 'DESC')->get();
        return view('admin.admin_user.list')->with(['userData' => $result]);
    }

    public function edit($id)
    {
        $userData = Admin::where('admin_id', $id)->first();
        $roles = Role::get();
        if ($userData) {
            return view('admin.admin_user.edit')->with(['userData' => $userData, 'rolesData' => $roles, 'currentRole' => $userData->roles]);
        } else {
            return redirect()->route('home');
        }
    }
    
    /**
     * Show the add admin page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function add()
    {
        $roles = Role::get();
        return view('admin.admin_user.add')->with(['rolesData' => $roles]);
    }

    /**
     * add user
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function insert(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:admins,email',
                'password' => 'required',
                'role_id' => 'required'
            ],
            [
                'name.required' => 'Please enter user name.',
                'email.required' => 'Please enter email.',
                'password.required' => 'Please enter password.',
                'role_id.required' => 'Please select role.'
            ]
        );

        if ($validator->fails()) {
            $return = '';
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                $return .= $message . "<br>";
            }
            _json(201, $return);
            // Session::flash('error', $return);
        } else {

            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
        
            $user = Admin::create($input);
            $user->assignRole($request->input('role_id'));

            if ($user) {
                $redirect = route('admin.admin_user');
                $arr = array("redirect" => $redirect);
                _json(200, 'User added successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }
    public function editProfile()
    {
        return view('admin.edit_account_info')->with(['adminAccountData' => Auth::guard('admin')->user()]);
    }

    public function update(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:admins,email,' . $request->id . ',admin_id',
                'role_id' => 'required'
            ],
            [
                'name.required' => 'Please enter name.',
                'email.required' => 'Please enter email.',
                'role_id.required' => 'Please select role.'
            ]
        );

        if ($validator->fails()) {
            $return = '';
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                $return .= $message . "<br>";
            }
            _json(201, $return);
            // Session::flash('error', $return);
        } else {

            $input = $request->all();
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = Arr::except($input, array('password'));
            }

            $user = Admin::find($request->id);
            $user->update($input);
            DB::table('model_has_roles')->where('model_id', $request->id)->delete();

            $user->assignRole($request->input('role_id'));

            if ($user) {
                $redirect = route('admin.admin_user');
                $arr = array("redirect" => $redirect);
                _json(200, 'User updated successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function updateProfile(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required'],
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
            // Session::flash('error', $return);
        } else {
            $profileImage = '';
            if ($request->hasFile('profile_image')) {
                $profileImage = 'profile_image_' . time() . '.' . $request->profile_image->extension();
                $request->profile_image->move(public_path('uploads/profile_image/'), $profileImage);
            } else {
                $profileImage = $request->old_image_path;
            }
            $admin = Admin::findOrFail($request->id);
            $admin->name = $request['name'];
            $admin->profile_image = $profileImage;
            $admin->save();

            if ($admin) {
                $redirect = route('admin.dashboard');
                $arr = array("redirect" => $redirect);
                _json(200, 'Dashboard updated successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function changePassword(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'current_password' => ['required', new MatchOldPassword('admin')],
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
            $admin = Admin::where('admin_id', $request->id)->update([
                'password' => Hash::make($request['confirm_password']),
            ]);

            if ($admin) {
                $redirect = route('admin.dashboard');
                $arr = array("redirect" => $redirect);
                _json(200, 'Profile updated successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }
}
