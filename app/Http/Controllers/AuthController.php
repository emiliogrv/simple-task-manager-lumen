<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller {
	/**
	 * @var \Tymon\JWTAuth\JWTAuth
	 */
	protected $jwt;

	public function __construct(JWTAuth $jwt) {
		$this->jwt = $jwt;
	}

	/**
	 * login user into app
	 * @param  Request $request
	 * @return token|error
	 */
	public function login(Request $request) {
		$this->validate($request, [
			'email' => 'required|email|max:255',
			'password' => 'required',
		]);

		try {
			if (!$token = $this->jwt->attempt($request->only('email', 'password'))) {
				return response()->json(['error' => 'user_not_found'], 404);
			}

		} catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			return response()->json(['error' => 'token_expired'], 500);

		} catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			return response()->json(['error' => 'token_invalid'], 500);

		} catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
			return response()->json(['error' => $e->getMessage()], 500);

		}

		return response()->json(compact('token'));
	}

	/**
	 * Retrieve info from user token
	 * @param  Request $request
	 * @return user info
	 */
	public function logged(Request $request) {
		$user = $request->user();

		return response()->json(compact('user'));
	}

	/**
	 * Destroy token and logout user
	 * @return void
	 */
	public function logout() {
		$this->jwt->invalidate($this->jwt->getToken());

		return response()->json('', 204);
	}
}