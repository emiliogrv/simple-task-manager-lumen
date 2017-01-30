<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('tasks', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('created_by')->unsigned()->index();
			$table->integer('assigned_to')->unsigned()->index();
			$table->integer('priority_id')->unsigned()->index();
			$table->string('title', 45);
			$table->string('description', 300);
			$table->date('due_date');
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('created_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('assigned_to')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('priority_id')->references('id')->on('priorities')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('tasks');
	}
}
