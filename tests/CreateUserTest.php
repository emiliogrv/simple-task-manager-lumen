<?php

//use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CreateUserTest extends TestCase {
	use DatabaseTransactions;

	/**
	 * A test create user, login and see information.
	 *
	 * @return void
	 */
	public function testCreateUser() {
		$user = $this->createUser();

		$this->actingAs($user)
			->get('/api/v1/authenticate')
			->receiveJson()
			->seeJsonStructure([
				'user' => [
					'id',
					'email',
					'first_name',
					'last_name',
					'created_at',
					'updated_at',
				],
			]);
	}
}
