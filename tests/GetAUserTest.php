<?php

//use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class GetAUserTest extends TestCase {
	use DatabaseTransactions;

	/**
	 * A test get details from a user with tasks.
	 *
	 * @return void
	 */
	public function testGetAUserWithTask() {
		$user = $this->createUser();

		$this->actingAs($user)
			->get('/api/v1/users/' . $user->id . '?with=tasks')
			->receiveJson()
			->seeJsonStructure([
				'user' => [
					'id',
					'email',
					'first_name',
					'last_name',
					'created_at',
					'updated_at',
					'deleted_at',
					'tasks',
				],
			]);
	}

	/**
	 * A test get details from a user without tasks.
	 *
	 * @return void
	 */
	public function testGetAUserWithoutTask() {
		$user = $this->createUser();

		$this->actingAs($user)
			->get('/api/v1/users/' . $user->id)
			->receiveJson()
			->seeJsonStructure([
				'user' => [
					'id',
					'email',
					'first_name',
					'last_name',
					'created_at',
					'updated_at',
					'deleted_at',
				],
			])
			->dontSeeJson([
				'user' => [
					'tasks',
				],
			]);
	}
}