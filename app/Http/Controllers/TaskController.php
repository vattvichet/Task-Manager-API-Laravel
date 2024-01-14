<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    //
    public function index(Request $request)
    {
        return new TaskCollection(Task::all());
        // return response()->json(new TaskCollection(Task::all()), 201);
    }
    public function show(Request $request, Task $task)
    {
        return new TaskResource($task);
    }
}
