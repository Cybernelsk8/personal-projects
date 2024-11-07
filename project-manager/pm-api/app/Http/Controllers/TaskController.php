<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Status;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function  index(string $id = '') {
        try {

            $tasks = Task::whereNull('deleted_at')
                ->when(!empty($id),function($query) use($id){
                    $query->where('id',$id);
                })->with(['project','status','user'])
                ->get();
            return response($tasks);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function tasksByStatus (string $project_id) {
        try {

            $tasksByStatus = Status::with(['tasks' => function($query) use($project_id) {
                    $query->where('project_id',$project_id)
                        ->where('user_id',auth()->user()->id);
                }])->get();
            
            return response($tasksByStatus);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function store (Request $request) {
        $request->validate([
            'title' => 'required|string|max:80',
            'description' => 'required|string|max:255|min:5',
            'project_id' => 'required|exists:projects,id',
            'status_id' => 'required|exists:statuses,id',
        ]);

        try {
            $task = Task::create([
                'title' => ucwords(strtolower($request->title)),
                'description' => trim($request->description),
                'project_id' => $request->project_id,
                'status_id' => $request->status_id,
                'user_id' => $request->user_id ?? auth()->user()->id
            ]);

            return response($task);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }
    

    public function update (Task $task, Request $request) {
        $request->validate([
            'title' => 'required|string|max:80',
            'description' => 'required|string|max:255|min:5',
            'project_id' => 'required|exists:projects,id',
            'status_id' => 'required|exists:statuses,id',
        ]);

        try {

            $task->title = ucwords(strtolower($request->title));
            $task->description = trim($request->description);
            $task->project_id = $request->project_id;
            $task->status_id = $request->status_id;
            $task->user_id = $request->user_id ?? auth()->user()->id;
            $task->save();

            return response('Tarea actualizada correctamente');

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function destroy(Task $task) {
        try {
            $task->deleted_at = now();
            $task->save();
            return response('Tarea eliminada correctamente');
        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }
}
