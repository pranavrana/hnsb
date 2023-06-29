<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class GeneralSettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:setting-list|setting-create|setting-edit|setting-delete', ['only' => ['index']]);
        $this->middleware('permission:setting-create', ['only' => ['add','insert']]);
        $this->middleware('permission:setting-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:setting-delete', ['only' => ['delete']]);
    }

    /**
     * Show the general settings listing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $result = GeneralSetting::orderBy('general_setting_id', 'DESC')->get();
        return view('admin.general_setting.list')->with(['generalSettingData' => $result]);
    }

    /**
     * Show the add general settings page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function add()
    {
        return view('admin.general_setting.add');
    }

    /**
     * Show the add general settings page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function insert(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'setting_label' => ['required'],
                'setting_key' => ['required'],
                'setting_value' => ['required'],
            ],
            [
                'setting_label.required' => 'Please enter general setting name.',
                'setting_key.required' => 'Please enter general setting key.',
                'setting_value.required' => 'Please enter general setting value.',
            ]
        );

        if ($validator->fails()) {
            $return = '';
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                $return .= $message . "<br>";
            }
            // Session::flash('error', $return);
            _json(201, $return);
        } else {
            $generalSetting = GeneralSetting::create([
                'label' => $request['setting_label'],
                'key' => $request['setting_key'],
                'value' => $request['setting_value'],
            ]);

            if ($generalSetting) {
                $redirect = route('admin.general_setting');
                $arr = array("redirect" => $redirect);
                _json(200, 'General Setting added successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function edit($id)
    {
        $generalSettingData = GeneralSetting::where('general_setting_id', $id)->first();
        if ($generalSettingData) {
            return view('admin.general_setting.edit')->with(['generalSettingData' => $generalSettingData]);
        } else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'setting_label' => ['required'],
                'setting_key' => ['required'],
                'setting_value' => ['required'],
            ],
            [
                'setting_label.required' => 'Please enter general setting name.',
                'setting_key.required' => 'Please enter general setting name.',
                'setting_value.required' => 'Please enter general setting value.',
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

            $generalSetting = GeneralSetting::findOrFail($request->id);
            $generalSetting->label = $request['setting_label'];
            $generalSetting->key = $request['setting_key'];
            $generalSetting->value = $request['setting_value'];
            $generalSetting->save();

            if ($generalSetting) {
                $redirect = route('admin.general_setting');
                $arr = array("redirect" => $redirect);
                _json(200, 'General Setting updated successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function updateStatus(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'setting' => ['required'],
                'status' => ['required'],
            ],
            [
                'setting.required' => 'Something went wrong plase try again1!',
                'status.required' => 'Something went wrong plase try again!2'
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

            $generalSetting = GeneralSetting::findOrFail($request->setting);
            $generalSetting->status = $request['status'];
            $generalSetting->save();

            if ($generalSetting) {
                $arr = array();
                _json(200, 'Status updated successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }
}
