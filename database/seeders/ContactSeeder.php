<?php
namespace Database\Seeders;

use App\Domains\Feedback\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<9; $i++){
            Contact::factory()->create();
        }
    }
}
