<?php

abstract class TestCase extends Laravel\Lumen\Testing\TestCase {
	/**
	 * Creates the application.
	 *
	 * @return \Laravel\Lumen\Application
	 */
	public function createApplication() {
		return require __DIR__ . '/../bootstrap/app.php';
	}

	public function createUser() {
		return factory(App\Models\User::class)->create([
			'first_name' => 'phpunit',
			'last_name' => 'phpunit',
			'email' => 'phpunit@test.com',
			'password' => app('hash')->make('123456'),
		]);
	}
}
