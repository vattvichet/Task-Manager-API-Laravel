<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
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
        $project = Project::find($id);
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
