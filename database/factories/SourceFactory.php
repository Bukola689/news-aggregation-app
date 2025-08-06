<?php

namespace Database\Factories;
use App\Models\Source;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SourceFactory extends Factory
{
    protected $model = Source::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->unique()->company();

        return [
             'name' => $name,
            'slug' => Str::slug($name),
            'url' => $this->faker->url(),
            'logo_url' => $this->faker->imageUrl(100, 100),
        ];
    }
}
