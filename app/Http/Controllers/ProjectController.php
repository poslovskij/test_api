<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		return response()->json(Project::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		try {
			$request->validate([
				'name' => 'required|string|max:255',
				'description' => 'nullable|string',
			]);

			$project = Project::create($request->all());
			return response()->json($project, 201);

		} catch (\Exception $e) {
			\Log::error('Error creating project:', ['error' => $e->getMessage()]);
			return response()->json(['error' => $e->getMessage()], 500);
		}
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
		return response()->json($project, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
		try {

			$request->validate([
				'name' => 'string|max:255',
				'description' => 'nullable|string',
			]);

			$project->update($request->all());
			return response()->json($project, 200);

		} catch (\Exception $e) {
			\Log::error('Error update project:', ['error' => $e->getMessage()]);
			return response()->json(['error' => $e->getMessage()], 500);
		}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
		$project->delete();

		return response()->json(null, 204);
    }
}
