<?php

use Illuminate\Database\Seeder;

class PrioritiesTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('priorities')->insert([
			['name' => 'low'],
			['name' => 'medium'],
			['name' => 'high'],
		]);
	}
}
