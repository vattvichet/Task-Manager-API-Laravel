<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
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
        // return new TaskCollection($tasks);
        return response()->json([
            'status' => 'success',
            'data' => $tasks
        ], 200,);
    }
    public function show($id)
    {
        $task = Task::find($id);
        if ($task !== null) {
            return response()->json([
                'status' => 'success',
                'data' => $task
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'ID Invalid'
            ], 404);
        }
    }

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        $task = Task::create($validated);
        return response()->json([
            'status' => 'success',
            'data' => $task
        ], 200);

        // return new TaskResource($task);;
    }
    public function update(UpdateTaskRequest $request, $id)
    {
        $task = Task::find($id);
        if ($task !== null) {
            $validated = $request->validated();
            $task->update($validated);
            return response()->json([
                'status' => 'success',
                'data' => $task
            ], 201);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'ID Invalid'
            ], 404);
        }
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        if ($task !== null) {
            $task->delete();
            return response()->json([
                'message' => 'item is deleted',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'ID Invalid'
            ], 404);
        }
    }
}
