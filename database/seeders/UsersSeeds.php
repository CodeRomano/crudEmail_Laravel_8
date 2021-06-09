<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeds extends Seeder
{
   /**
   * Run the database seeds.
   *
   * @return void
   */
   public function run()
   {
       
     $user = new User();
     $user->setAttribute('email', 'pedroxromano18@gmail.com');
     $user->setAttribute('password', bcrypt('admin'));
     $user->setAttribute('name', 'Administrador');
     $user->setAttribute('phone_number', '997634134');
     $user->setAttribute('num_doc_identity', '1043816522');
     $user->setAttribute('date_of_birth', date('y-m-d', strtotime('1986-10-18')));
     $user->setAttribute('flag_admin', 1);
     $user->setAttribute('city_id', 1);
     $user->save();

   }
}
