<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
	public function index(Project $project)
	{
		$tasks = $project->tasks();

		// фільтрування по статусу виконання
		if (request()->has('is_completed')) {
			$tasks->where('is_completed', request('is_completed'));
		}

		return response()->json($tasks->get(), 200);
	}

    /**
     * Store a newly created resource in storage.
     */
	public function store(Request $request, Project $project)
	{
		try {

			$request->validate([
				'title' => 'required|string|max:255',
				'description' => 'nullable|string',
			]);

			$task = $project->tasks()->create($request->all());
			return response()->json($task, 201);

		} catch (\Exception $e) {
			\Log::error('Error creating task:', ['error' => $e->getMessage()]);
			return response()->json(['error' => $e->getMessage()], 500);
		}
	}

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
		return response()->json($task, 200);
    }

    /**
     * Update the specified resource in storage.
     */
	public function update(Request $request, Task $task)
	{
		try {

			$request->validate([
				'title' => 'string|max:255',
				'description' => 'nullable|string',
				'is_completed' => 'boolean',
			]);

			$task->update($request->all());
			return response()->json($task, 200);

		} catch (\Exception $e) {
			\Log::error('Error update task:', ['error' => $e->getMessage()]);
			return response()->json(['error' => $e->getMessage()], 500);
		}
	}

    /**
     * Remove the specified resource from storage.
     */
	public function destroy(Task $task)
	{
		$task->delete();
		return response()->json(null, 204);
	}
}
