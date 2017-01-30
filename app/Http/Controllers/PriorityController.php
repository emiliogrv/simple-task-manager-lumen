<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Priority;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PriorityController extends Controller {
	/**
	 * Get priorities registered into system
	 * @param  Request $request
	 * @return Priorities
	 */
	public function index(Request $request) {
		$Priority = new Priority;

		$this->validate($request, [
			'fields' => 'filter_field:' . $Priority->visibles(),
			'paginate' => 'numeric|min:1|max:500',
		]);

		$request->has('paginate') ? $paginate = $request->paginate : $paginate = 15;

		if ($request->has('fields')) {
			$priorities = $Priority::paginate($paginate, explode(',', str_replace(' ', '', $request->only('fields')['fields'])));
		} else {
			$priorities = $Priority::paginate($paginate);
		}

		return response()->json(compact('priorities'));
	}

	/**
	 * Store priorities into system
	 * @param  Request $request
	 * @return Priority
	 */
	public function store(Request $request) {
		$this->validate($request, [
			'name' => 'required|unique:priorities|max:45',
		]);

		$priority = null;

		DB::transaction(function () use (&$request, &$priority) {
			$priority = Priority::create($request->all());
		});

		return response()->json(compact('priority'), 201);
	}

	/**
	 * Retrieve a priority detail
	 * @param  Request $request
	 * @param  int $id
	 * @return Priority
	 */
	public function show(Request $request, $id) {
		$Priority = new Priority;

		$this->validate($request, [
			'fields' => 'filter_field:' . $Priority->visibles(),
		]);

		if ($request->has('fields')) {
			$priority = $Priority::findOrFail($id, explode(',', str_replace(' ', '', $request->only('fields')['fields'])));
		} else {
			$priority = $Priority::findOrFail($id);
		}

		return response()->json(compact('priority'));
	}

	/**
	 * Update a priority
	 * @param  Request $request
	 * @param  int $id
	 * @return Priority
	 */
	public function update(Request $request, $id) {
		$this->validate($request, [
			'name' => [
				'required',
				Rule::unique('priorities')->ignore($id),
				'max:45',
			],
		]);

		$priority = Priority::findOrFail($id);

		DB::transaction(function () use (&$request, &$priority) {
			$priority->update($request->only(['name']));
			$priority->save();
		});

		return response()->json(compact('priority'));
	}

	/**
	 * Softdelete a priority
	 * @param  int $id
	 * @return Void
	 */
	public function destroy($id) {
		$priority = Priority::findOrFail($id);
		$priority->delete();

		return response()->json('', 204);
	}

	/**
	 * Restore a priority with softdeleted
	 * @param  int $id
	 * @return Priority
	 */
	public function restore($id) {
		$priority = Priority::withTrashed()->findOrFail($id);
		$priority->restore();

		return response()->json(compact('priority'));
	}
}