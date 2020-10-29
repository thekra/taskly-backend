<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = User::all()->random()->id;
        return [
            'user_id' => $user_id,
            'task_name' => $this->faker->name,
            'comment' => $this->faker->unique()->safeEmail,
            'is_completed' => rand(0, 1),
            'task_date' => now(),
        ];
    }
}
