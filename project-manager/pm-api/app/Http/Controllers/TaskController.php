<?php

namespace App\Http\Controllers;

use App\Models\Project;
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

    public function tasksUser() {

        try {
            $tasks = Task::whereNull('deleted_at')
                ->where('user_id',auth()->user()->id)
                ->with(['project','status','user'])
                ->get();
            return response($tasks);

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
    
    public function storeProjectTasks(Request $request) {
        $request->validate([
            'project.title' => 'required|string|max:80',
            'project.description' => 'required|string|max:255|min:5',
        ]);

        try {
            
            $project = Project::create([
                'title' => ucwords(strtolower($request->project['title'])),
                'description' => $request->project['description']
            ]);

            

            $i = 0;

            if($project){

                if(count($request->project['tasks']) > 0) {

                    foreach ($request->project['tasks'] as $task) {

                        $_task = Task::create([
                            'title' => $task['title'],
                            'description' => $task['description'],
                            'user_id' => $task['user_id'],
                            'project_id' => $project->id,
                            'status_id' => 1,
                        ]);
    
                        if($_task){
                            $i++;
                        }
                    }
    
                    if($i === count($request->project['tasks'])) {
                        return response('Project and tasks created successfully');
                    }
                }

                return response('Project created successfully');

            }
            

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
