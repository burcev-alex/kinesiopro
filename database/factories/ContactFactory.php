<?php

namespace Database\Factories;

use App\Domains\Feedback\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\File;
use Orchid\Attachment\Models\Attachment;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        try {
            return [
                "city" => $this->faker->city(),
                "full_name" => $this->faker->name(),
                "url" => $this->faker->url(),
                "email" => $this->faker->email(),
                "phone" => [$this->faker->phoneNumber(), $this->faker->phoneNumber()],
                "address" => $this->faker->address(),
                "fb" => $this->faker->url(),
                "vk" => $this->faker->url(),
                "instagram" => $this->faker->url(),
                "youtube" => $this->faker->url(),
            ];
        } catch (\Throwable $th) {
            echo 'Message: ' . $th->getMessage();
        }
    }
}
