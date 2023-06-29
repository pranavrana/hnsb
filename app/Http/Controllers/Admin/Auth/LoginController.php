<?php

namespace App\Http\Controllers\Admin\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\ThrottlesLogins;
use Auth;
use Route;
use session;
class LoginController extends Controller
{
    // use ThrottlesLogins;
    /**
     * Show the login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }
    public function index()
    {
       return view('admin.login');
    }
    /**
     * Login the admin.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
       $this->validator($request);
       // //check if the user has too many login attempts.
       //  if ($this->hasTooManyLoginAttempts($request)){
       //  //Fire the lockout event.
       //  $this->fireLockoutEvent($request);
       //  //redirect the user back after lockout.
       //  return $this->sendLockoutResponse($request);
       //  }

       if(Auth::guard('admin')->attempt($request->only('email','password'),$request->filled('remember')))
       {
        //Authentication passed...
        return redirect()
        ->route('admin.dashboard')
        ->with('status',"You are logged in successfully.");
        }
        //keep track of login attempts from the user.
        // $this->incrementLoginAttempts($request);
        //Authentication failed...
        return $this->loginFailed();
    }
    /**
     * Logout the admin.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
      Auth::guard('admin')->logout();
      return redirect()
      ->route('admin.login');
    }
    /**
     * Validate the form data.
     *
     * @param \Illuminate\Http\Request $request
     * @return
     */
    private function validator(Request $request)
    {
      //validation rules.
        $rules = [
            'email'    => 'required|email|exists:admins|min:5|max:191',
            'password' => 'required|string|min:4|max:255',
        ];
    //custom validation error messages.
        $messages = [
            'email.exists' => 'These credentials do not match with our records.',
        ];
    //validate the request.
        $request->validate($rules,$messages);
    }
    /**
     * Redirect back after a failed login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginFailed()
    {
      return redirect()
        ->back()
        ->withInput()
        ->with('error','Login failed, please try again!');
    }

    public function username(){
        return 'email';
    }
}
