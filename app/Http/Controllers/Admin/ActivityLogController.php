<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:group-list|group-create|group-edit|group-delete', ['only' => ['index']]);
        $this->middleware('permission:group-create', ['only' => ['add', 'insert']]);
        $this->middleware('permission:group-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:group-delete', ['only' => ['delete']]);
    }


    /**
     * Show the Group listing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $result = Activity::with('causer')->select(DB::raw("activity_log.*,date_format(activity_log.created_at,'%Y-%m-%d %H:%i:%s') as log_date"))->orderBy('id','desc')->get();
        return view('admin.activity_log.list')->with(['activityLogData' => $result]);
    }
}
