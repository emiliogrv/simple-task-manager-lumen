<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use DB;
use Illuminate\Http\Request;

class TaskController extends Controller {
	/**
	 * Get tasks registered into system
	 * @param  Request $request
	 * @return Tasks
	 */
	public function index(Request $request) {
		$Task = new Task;

		$this->validate($request, [
			'fields' => 'filter_field:' . $Task->visibles(),
			'paginate' => 'numeric|min:1|max:500',
		]);

		$request->has('paginate') ? $paginate = $request->paginate : $paginate = 15;

		if ($request->has('fields')) {
			$tasks = $Task::paginate($paginate, explode(',', str_replace(' ', '', $request->only('fields')['fields'])));
		} else {
			$tasks = $Task::paginate($paginate);
		}

		return response()->json(compact('tasks'));
	}

	/**
	 * Store tasks into system
	 * @param  Request $request
	 * @return Task
	 */
	public function store(Request $request) {
		$this->validate($request, [
			'assigned_to' => 'required|exists:users,id',
			'priority_id' => 'required|exists:priorities,id',
			'title' => 'required|max:45',
			'description' => 'required|max:300',
			'due_date' => 'required|date_format:Y-m-d|after:now',
		]);

		$task = null;

		DB::transaction(function () use (&$request, &$task) {
			$inputs = $request->all();
			$inputs['created_by'] = $request->user()->id;

			$task = Task::create($inputs);
		});

		return response()->json(compact('task'), 201);
	}

	/**
	 * Retrieve a task detail
	 * @param  Request $request
	 * @param  int $id
	 * @return Task
	 */
	public function show(Request $request, $id) {
		$Task = new Task;

		$this->validate($request, [
			'fields' => 'filter_field:' . $Task->visibles(),
		]);

		if ($request->has('fields')) {
			$task = $Task::findOrFail($id, explode(',', str_replace(' ', '', $request->only('fields')['fields'])));
		} else {
			$task = $Task::findOrFail($id);
		}

		return response()->json(compact('task'));
	}

	/**
	 * Update a task
	 * @param  Request $request
	 * @param  int $id
	 * @return Task
	 */
	public function update(Request $request, $id) {
		$this->validate($request, [
			'assigned_to' => 'required|exists:users,id',
			'priority_id' => 'required|exists:priorities,id',
			'title' => 'required|max:45',
			'description' => 'required|max:300',
			'due_date' => 'required|date_format:Y-m-d|after:now',
		]);

		$task = Task::findOrFail($id);

		DB::transaction(function () use (&$request, &$task) {
			$task->update($request->only(['assigned_to', 'priority_id', 'title', 'description', 'due_date']));
			$task->save();
		});

		return response()->json(compact('task'));
	}

	/**
	 * Softdelete a task
	 * @param  int $id
	 * @return Void
	 */
	public function destroy($id) {
		$task = Task::findOrFail($id);
		$task->delete();

		return response()->json('', 204);
	}

	/**
	 * Restore a task with softdeleted
	 * @param  int $id
	 * @return Task
	 */
	public function restore($id) {
		$task = Task::withTrashed()->findOrFail($id);
		$task->restore();

		return response()->json(compact('task'));
	}
}