<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MemberRole;

class MemberRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MemberRole::create(['description' => 'Regulier lid']);
        MemberRole::create(['description' => 'Erelid']);
        MemberRole::create(['description' => 'Studentlid']);
        MemberRole::create(['description' => 'Proeflid']);
    }
}
