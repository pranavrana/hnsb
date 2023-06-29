<?php
  
namespace App\Rules;
  
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
  
class MatchOldPassword implements Rule
{

    public $guard;

    public function __construct($guard)
    {
        $this->guard = $guard;
    }
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Hash::check($value, Auth::guard($this->guard)->user()->password);
    }
   
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        // return 'The :attribute is match with old password.';
        return 'Given :attribute is incorrect, please provide correct current password.';
    }
}