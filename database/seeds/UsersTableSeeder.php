<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      User::create([
         'nombres' => 'admin',
         'apellidos'  => 'admin',
         'username'   => 'admin',
         'email'      => 'admin@admin.com',
         'tipo_usuario'   => 'ADMINISTRADOR',
         'password'   =>  Hash::make('123456')
      ]);
    }
}
