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
	    $folder->name = 'Folder 1';
	    $folder->description = 'Folder 1 desc';
	    $folder->save();

	    $folder = new Folder();
	    $folder->id = 2;
	    $folder->name = 'Folder 2';
	    $folder->description = 'Folder 2 desc';
	    $folder->save();
    }
}
