<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\HeadOfFamilyFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\UserFactory;
class HeadOfFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserFactory::new()->count(10)->create()->each(function ($user) {
            HeadOfFamilyFactory::new()->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
