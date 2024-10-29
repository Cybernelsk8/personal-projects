<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index() {
        try {
            
            $statuses = Status::withCount(['tasks'])
            ->whereNull('deleted_at')
            ->get();
            
            return response($statuses);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function taskForUser() {
        try {
            
            $taks = Status::whereNull('deleted_at')
                ->with([
                    'tasks' => function($query) {
                        $query->where('user_id',auth()->user()->id);
                    }
                ])
                ->get();

            return response($taks);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function show(int $id) {
        try {

            $status = Status::with(['tasks.status','tasks.user','tasks.project'])
            ->whereNull('deleted_at')
            ->where('id',$id)
            ->first();

            return response($status);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:80'
        ]);

        try {
            
            $status = Status::create([
                'name' => ucwords(strtolower($request->name))
            ]);

            return response($status);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function update(Status $status, Request $request) {
        
        $request->validate([
            'name' => 'required|string|max:80'
        ]);

        try {
            $status->name = ucwords(strtolower($request->name));
            $status->save();
            return response('Estado actualizado correctamente');
        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function destroy(Status $status) {
        try {
            $status->deleted_at = now();
            $status->save();
            return response('Estado eliminado correctamente');
        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }
}
