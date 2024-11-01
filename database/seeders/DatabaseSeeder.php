<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Role::create(['name'=>'admin']);
        Role::create(['name'=>'moderator']);
        Role::create(['name'=>'user']);
        Role::create(['name'=>'event']);

        \App\Models\User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@photo.com',
            'password'=>Hash::make(12345678),
            'status'=>1
        ])->assignRole('admin');

        \App\Models\User::factory()->create([
            'name' => 'Test Moderator',
            'email' => 'moderator@photo.com',
            'password'=>Hash::make(12345678),
            'status'=>1
        ])->assignRole('moderator');

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@photo.com',
            'password'=>Hash::make(12345678),
            'status'=>1
        ])->assignRole('user');

        \App\Models\User::factory()->create([
            'name' => 'Test Event',
            'email' => 'event@photo.com',
            'password'=>Hash::make(12345678),
            'status'=>1
        ])->assignRole('event');


    }
}
