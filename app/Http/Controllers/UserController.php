<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller {
	/**
	 * Get users registered into system
	 * @param  Request $request
	 * @return Users
	 */
	public function index(Request $request) {
		$User = new User;

		$this->validate($request, [
			'fields' => 'filter_field:' . $User->visibles(),
			'paginate' => 'numeric|min:1|max:500',
		]);

		$request->has('paginate') ? $paginate = $request->paginate : $paginate = 15;

		if ($request->has('fields')) {
			$users = $User::paginate($paginate, explode(',', str_replace(' ', '', $request->only('fields')['fields'])));
		} else {
			$users = $User::paginate($paginate);
		}

		return response()->json(compact('users'));
	}

	/**
	 * Store users into system
	 * @param  Request $request
	 * @return User
	 */
	public function store(Request $request) {
		$this->validate($request, [
			'first_name' => 'required|max:45',
			'last_name' => 'required|max:45',
			'email' => 'required|unique:users|email|max:45',
			'password' => 'required',
		]);

		$user = null;

		DB::transaction(function () use (&$request, &$user) {
			$user = User::create($request->all());
		});

		return response()->json(compact('user'), 201);
	}

	/**
	 * Retrieve a user detail
	 * @param  Request $request
	 * @param  int $id
	 * @return User
	 */
	public function show(Request $request, $id) {
		$User = new User;

		$this->validate($request, [
			'fields' => 'filter_field:' . $User->visibles(),
			'with' => 'filter_field:' . $User->includes(),
		]);

		if ($request->has('with')) {
			$user = $User::with(str_replace(' ', '', $request->only('with')['with']));
		} else {
			$user = $User;
		}

		if ($request->has('fields')) {
			$user = $user->findOrFail($id, explode(',', str_replace(' ', '', $request->only('fields')['fields'])));
		} else {
			$user = $user->findOrFail($id);
		}

		return response()->json(compact('user'));
	}

	/**
	 * Update a user
	 * @param  Request $request
	 * @param  int $id
	 * @return User
	 */
	public function update(Request $request, $id) {
		$this->validate($request, [
			'first_name' => 'required|max:45',
			'last_name' => 'required|max:45',
			'email' => [
				'required',
				Rule::unique('users')->ignore($id),
				'email',
				'max:45',
			],
			'password' => 'required',
		]);

		$user = User::findOrFail($id);

		DB::transaction(function () use (&$request, &$user) {
			$user->update($request->only(['first_name', 'last_name', 'email', 'password']));
			$user->save();
		});

		return response()->json(compact('user'));
	}

	/**
	 * Softdelete a user
	 * @param  int $id
	 * @return Void
	 */
	public function destroy($id) {
		if (User::count() > 1) {
			$user = User::findOrFail($id);
			$user->delete();

			return response()->json('', 204);
		}

		return response()->json(['error' => 'Only one user left'], 422);
	}

	/**
	 * Restore a user with softdeleted
	 * @param  int $id
	 * @return User
	 */
	public function restore($id) {
		$user = User::withTrashed()->findOrFail($id);
		$user->restore();

		return response()->json(compact('user'));
	}
}