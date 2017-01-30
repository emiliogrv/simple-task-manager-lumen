<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		/**
		 * Personalized valitadions
		 */
		Validator::extend('filter_field', function ($attribute, $value, $parameters, $validator) {
			$values = explode(',', str_replace(' ', '', $value));

			return count(array_intersect($values, $parameters)) == count($values);
		});

		Validator::replacer('filter_field', function ($message, $attribute, $rule, $parameters) {
			return str_replace(':field', $attribute, 'The selected :field is invalid.');
		});
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}
