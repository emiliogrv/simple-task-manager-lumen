<?php

class ErrorByNotAuthenticateTest extends TestCase {

	/**
	 * A test create user, login and see information.
	 *
	 * @return void
	 */
	public function testErrorByNotAuthenticate() {
		$this->get('/api/v1/authenticate')
			->receiveJson()
			->seeJsonStructure([
				'error',
			])
			->seeJson([
				'error' => 'Unauthorized.',
			]);
	}
}
