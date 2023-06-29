<?php
    
namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use DB;
    
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index']]);
        $this->middleware('permission:role-create', ['only' => ['add','insert']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['delete']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rolesData = Role::orderBy('id', 'DESC')->get();
        return view('admin.roles_and_permission.list')->with(['rolesData' => $rolesData]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $permission = Permission::get();
        $permission = static::_group_by($permission,"group_name");
        return view('admin.roles_and_permission.add',compact('permission'));
    }
    

    /**
     * Show the add Group page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function insert(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:roles,name',
                'permission' => 'required',
            ],
            [
                'name.required' => 'Please enter name.',
                'permission.required' => 'Please choose atleast one permission',
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
            $role = Role::create(['name' => $request['name']]);
            $role->syncPermissions($request['permission']);
            if ($role) {
                $redirect = route('admin.roles_and_permission');
                $arr = array("redirect" => $redirect);
                _json(200, 'Roles added successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get()->toArray();
        $permission = static::_group_by($permission,"group_name");
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    
        // dd($permission);
        return view('admin.roles_and_permission.edit',compact('role','permission','rolePermissions'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'permission' => 'required',
            ],
            [
                'name.required' => 'Please enter name.',
                'permission.required' => 'Please choose atleast one permission',
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
            $role = Role::find($request->id);
            $role->name = $request['name'];
            $role->save();
        
            $role->syncPermissions($request['permission']);

            if ($role) {
                $redirect = route('admin.roles_and_permission');
                $arr = array("redirect" => $redirect);
                _json(200, 'Role Updated successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }

    function _group_by($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }
}