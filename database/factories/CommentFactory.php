<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory {
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array {

		$tableNames = ['news', 'video_posts'];
//		$tableNames = ['comments'];

		$key = rand(0, 1);
//		$key = 0;
		$tableName = $tableNames[$key];

		$user = User::all()[0];
		if (!$user)
			return [];

		$id = rand(1, 3);
		$modelData = DB::table($tableName)->find($id);

		return [
			'user_id' => $user->id,
			'commentable_id' => $modelData->id,
			'commentable_type' => $tableName,
			'text' => fake()->text,
		];
	}
}
