<?php

namespace Database\Seeders;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $usuario = new User;
        $usuario->name="Maria Cocom";
        $usuario->username = 'Admin';
        $usuario->email = 'admin@admin.com';
        $usuario->password = '12345678';
        $usuario->role = 'admin';
        $usuario->save();
    }

   
}
