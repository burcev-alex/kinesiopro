<?php

namespace Database\Seeders;

use App\Domains\Course\Models\RefChar;
use App\Domains\Course\Models\RefCharsValue;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Seeder;


use function GuzzleHttp\Promise\each;

class RefCharSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $refs = [
            'format' => 'Формат',
            'direct' => 'Направление',
            'city' => 'Город',
        ];

        foreach ($refs as $key => $value) {
            RefChar::factory()->state([
                'slug' => $key,
                'name' => $value
            ])->has(RefCharsValue::factory()->count(7), 'values')->create();
        }
    }
}
