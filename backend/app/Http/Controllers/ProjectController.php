<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::with('users', 'enrollments')->get();
        return $projects;
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'web_link' => 'required|string|max:255',
            'github_link' => 'required|string|max:255',
            'enrollment_id' => 'required|integer',
        ]);

        $existingProject = Project::where('web_link', $request->input('web_link'))->first();

        if ($existingProject) {
            Auth::user()->projects()->attach($existingProject);
            return response()->json(['message' => 'User attached to an existing project'], 200);
        } else {
            $project = new Project([
                'name' => $request->input('name'),
                'status' => $request->input('status'),
                'web_link' => $request->input('web_link'),
                'github_link' => $request->input('github_link'),
            ]);
            Auth::user()->projects()->save($project);

        }

        $enrollment_id = $request->input('enrollment_id');
        $project->enrollments()->attach($enrollment_id);

        return response()->json(['message' => 'Project created successfully'], 201);
    }

    public function update(Request $request, Project $project){
        $request->validate([
            'status' => 'string|required'
        ]);
        return $project->update($request->all());
    }

    public function getUserProjects()
    {
        $user = Auth::user();
        $userProjects = $user->projects()->with('enrollments')->get();
        return $userProjects;
    }
}
