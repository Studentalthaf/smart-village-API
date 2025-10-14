<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\HeadOfFamilyFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\UserFactory;
use Database\Factories\FamilyMemberFactory;
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
            FamilyMemberFactory::new()->count(3)->create([
                'head_of_family_id' => $user->headOfFamily->id,
                'user_id' => UserFactory::new()->create()->id,
            ]);
        });

    }
}
