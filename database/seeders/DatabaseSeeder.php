<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@dcosa.lk')],
            [
                'name'     => env('ADMIN_NAME', 'Association Admin'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'changeme123')),
                'is_admin' => true,
            ]
        );

        $this->call(SiteContentSeeder::class);
    }
}
