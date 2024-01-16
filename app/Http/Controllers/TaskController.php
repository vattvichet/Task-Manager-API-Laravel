<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use App\Models\Task;
use Spatie\QueryBuilder\QueryBuilder;


class TaskController extends Controller
{
    //
    public function index(Request $request)
    {

        $tasks = QueryBuilder::for(Task::class)
            //filter can be more than one ['isDone','title']
            ->allowedFilters(['isDone'])
            ->defaultSort('-created_at')
            ->allowedSorts(['created_at', 'title'])
            ->paginate();

        return new TaskCollection($tasks);
        // return response()->json(new TaskCollection(Task::all()), 201);
    }
    public function show(Request $request, Task $task)
    {
        return new TaskResource($task);
    }

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        $task = Task::create($validated);
        return new TaskResource($task);;
    }
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();
        $task->update($validated);
        return new TaskResource($task);
    }

    public function destroy(Request $request, Task $task)
    {
        $task->delete();
        return response()->noContent();
    }
}
