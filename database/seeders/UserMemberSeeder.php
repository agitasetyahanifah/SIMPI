<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserMember;

class UserMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserMember::factory()->count(10)->create();
    }
}
