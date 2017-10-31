<?php

use Illuminate\Database\Seeder;
use App\File;

class FileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $file = new File();
	    $file->folder_id = 1;
	    $file->filename = 'not a real file.pdf';
	    $file->filepath = 'somewhere/asdf34.pdf';
	    $file->contents = 'Example contents';
	    $file->save();

	    $file = new File();
	    $file->folder_id = 2;
	    $file->filename = 'not a real file 2.pdf';
	    $file->filepath = 'somewhere/asdgast3.pdf';
	    $file->contents = 'Example contents';
	    $file->save();
    }
}
