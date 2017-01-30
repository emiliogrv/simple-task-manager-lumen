<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('users')->insert([
			'first_name' => 'test',
			'last_name' => 'test',
			'email' => 'test@test.com',
			'password' => app('hash')->make('123456'),
		]);
	}
}
