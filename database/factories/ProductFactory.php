<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $category = Category::inRandomOrder()->first();
        $genders = ['male','female','andro'];
        return [
            'user_id'     => $user ? $user->id : User::factory(),
            'category_id' => $category ? $category->id : Category::factory(),
            'title'       => $this->faker->word . ' ' . $this->faker->word,
            'description' => $this->faker->paragraph,
            'gender'      => $genders[array_rand($genders)],
            'size'        => $this->faker->word,
            'tags'        => json_encode([$this->faker->word,$this->faker->word,$this->faker->word]),
            'status'      => 'available',
        ];
    }
}
