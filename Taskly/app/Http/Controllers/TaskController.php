<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index()
    {
        $user_id_logged = \Auth::id();
        $tasks = Task::where('user_id','=',$user_id_logged)->get();
        return response()->json($tasks);
    }

    public function create(Request $request)
    {
        $request->validate([
//            'user_id' => 'required|numeric|exists:users,id',
            'task_name' => 'required|string',
            'comment' => 'string',
            'task_date' => 'date'
        ]);

        $user_id_logged = \Auth::id();
        $task = Task::Create([
            'user_id' => $user_id_logged,//$request->get('user_id'),
            'task_name' => $request->get('task_name'),
            'comment' => $request->get('comment'),
            'task_date' => $request->get('task_date'),
        ]);

        return response()->json([
            'message' => 'تمت الاضافة بنجاح',
            'task' => $task
        ]);
    }


    public function show(Request $request)
    {
        $request->validate([
            'task_id' => 'required|numeric|exists:tasks,id',
        ]);

        $task = Task::with('user')
            ->where('id', '=', $request->get('task_id'))
            ->get();
        return response()->json($task);
    }


    public function update(Request $request)
    {
        $request->validate([
            'task_id' => 'required|numeric|exists:tasks,id',
            'task_name' => 'required|string',
            'comment' => 'string',
            'task_date' => 'date'
        ]);

        $task_name = $request->task_name;
        $comment = $request->comment;
        $task_date = $request->task_date;

        if ($task_name != null || $comment != null || $task_date != null) {
            if ($task_name != null) {
                Task::where('id', '=', $request->get('task_id'))->update(['task_name' => $task_name]);
            }
            if ($comment != null) {
                Task::where('id', '=', $request->get('task_id'))->update(['comment' => $comment]);
            }
            if ($task_date != null) {
                Task::where('id', '=', $request->get('task_id'))->update(['task_date' => $task_date]);
            }
        }

        $task = Task::where('id', '=', $request->get('task_id'))->first();
        return response()->json([
            'message' => 'Task has been updated successfullyُ',
            'event' => $task
        ], '200');
    }

    public function isTaskCompleted(Request $request)
    {
        $request->validate([
            'task_id' => 'required|numeric|exists:tasks,id',
            'is_completed' => 'required|boolean'
        ]);

        $is_completed = $request->is_completed;
        Task::where('id', '=', $request->get('task_id'))->update(['is_completed' => $is_completed]);
        $task = Task::where('id', '=', $request->get('task_id'))->first();

        return response()->json([
            'message' => 'Task has been updated successfullyُ',
            'event' => $task
        ], '200');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'task_id' => 'required|numeric|exists:tasks,id',
        ]);

        Task::where('id', '=' , $request->get('task_id'))->delete();

        return response()->json([
            'message' => 'Successfully deleted task',
        ], 200);
    }
}
