<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Project::mine()->with('timers')->get()->toArray();
    }

    public function store(Request $request)
    {
        // returns validated data as array
        $data = $request->validate(['name' => 'required|between:2,20']);

        // merge with the current user ID
        $data = array_merge($data, ['user_id' => auth()->user()->id]);

        $project = Project::create($data);

        return $project ? array_merge($project->toArray(), ['timers' => []]) : false;
    }
}
