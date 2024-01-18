<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    public function index()
    {
        $projects = Auth::user()->projects()->get();
        return response()->json(
            [
                'status' => 'success',
                'data' => $projects,
            ],
            200
        );
    }

    public function show(Request $request, $id)
    {
        $project = Auth::user()->projects()->find($id);
        if ($project !== null) {
            $tasks = $project->tasks()->where('project_id', $id)->get();
            return response()->json([
                'status' => 'success',
                'id' => $id,
                'title' => $project['title'],
                'tasks' => $tasks,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'id' => 'Project ID Invalid',
            ], 404);
        }
    }
    //
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();
        $project = Auth::user()->projects()->create($validated);
        return response()->json([
            'status' => 'success',
            'data' => $project,

        ], 201);
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        $project = Auth::user()->projects()->find($id);
        if ($project !== null) {
            $project->update($request->validated());
            return response()->json([
                'status' => 'success',
                'data' => $project,
            ], 202);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'ID Invalid',
            ]);
        }
    }
}
