<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $userId = 1;
        $user = \App\Models\User::factory()->create([
            'id' => $userId,
            'name' => 'Test User',
            'email' => fake()->email(),
            'email_verified_at' => now(),
            'password' => Hash::make('1234'),
            'phone' => '8911118881111',
            'telegram_chat_id' => '-123'
        ]);
         PersonalAccessToken::create([
             'id' => 1,
             'tokenable_type' => 'App\Models\User',
             'tokenable_id' => 1,
             'name' => 'authToken',
             'token' => 'bf0174f39f1526a1c51b4432e33779d87e0243f5bea83c13530398910a72f678',
             'abilities' => ["*"]
         ]);
    }
}
