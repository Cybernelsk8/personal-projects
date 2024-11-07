<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(string $id = '') {
        try {
            
            $projects = Project::whereNull('deleted_at')
                ->when(!empty($id),function($query) use($id) {
                    $query->where('id',$id);
                })->with(['tasks'])
                ->get();

            return response($projects);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function projectsByUser() {
        try {

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function store( Request $request) {
        $request->validate([
            'title' => 'required|string',
            'description' => 'string|max:255'
        ]);

        try {
            $project = Project::create([
                'title' => ucwords(strtolower($request->title)),
                'description' => trim($request->description ?? ''),
                'user_id' => auth()->user()->id
            ]);

            return response('Project created successfully =)');
            

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function update( Project $project, Request $request) {
        $request->validate([
            'title' => 'required|string',
            'description' => 'string|max:255'
        ]);

        try {

            $project->title = ucwords(strtolower($request->title));
            $project->description = trim($request->description ?? '');
            $project->save();

            return response('Proyecto actualizado correctamente');

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function destroy(Project $project) {
        
        try {
            
            $project->deleted_at = now();
            $project->save();
            return response('Proyecto eliminado correctamente');

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }
}
