<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
  public function run()
  {
    $role_employee = Role::where('name', 'User')->first();
    $role_manager  = Role::where('name', 'Surveyor')->first();
    $role_admin  = Role::where('name', 'Site Manager')->first();

    $employee = new User();
    $employee->name = 'User Name';
    $employee->email = 'user@user.com';
    $employee->password = bcrypt('user');
    $employee->save();
    $employee->roles()->attach($role_employee);

    $manager = new User();
    $manager->name = 'Surveyor Name';
    $manager->email = 'surveyor@surveyor.com';
    $manager->password = bcrypt('surveyor');
    $manager->save();
    $manager->roles()->attach($role_manager);

    $admin = new User();
    $admin->name = 'Site Manager Name';
    $admin->email = 'sitemanager@sitemanager.com';
    $admin->password = bcrypt('sitemanager');
    $admin->save();
    $admin->roles()->attach($role_admin);
  }
}