<?php

use Illuminate\Database\Seeder;
use App\Folder;

class FolderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $folder = new Folder();
	    $folder->id = 1;
	    $folder->name = 'Recycle Bin';
	    $folder->description = 'Where old files go to die';
	    $folder->save();
    }
}
