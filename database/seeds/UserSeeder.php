<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $year = date('Y');
        $role_admin = Role::find(1);

        DB::table('users')->insert([
            [
                'id_proveedor'=>null,
                'name'=>'ADMINISTRADOR',
                'email'=>'admin@correo.com',
                'password'=>bcrypt('temporal'.$year)
            ]
        ]);

        $user = User::find(1);
        $user->roles()->attach($role_admin);
    }
}
