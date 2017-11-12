<?php
use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
  public function run()
  {
    $role_employee = new Role();
    $role_employee->name = 'User';
    $role_employee->description = 'Hospital users (faculty, interns, groups, etc.)';
    /*
        Manage (create, edit, delete) folders for content (a folder would correspond to a specific project or group).

        Allowed to search for and view content areas that they are authorized to view
        If so authorized, they can upload, edit, and delete content
    */
    $role_employee->save();

    $role_manager = new Role();
    $role_manager->name = 'Surveyor';
    $role_manager->description = 'A surveyor with limited access'; // Login and search for and view selected content determined by the Site Manager
    $role_manager->save();

    $role_manager = new Role();
    $role_manager->name = 'Site Manager';
    $role_manager->description = 'Creates user accounts and manage folders';
    $role_manager->save();
  }
}