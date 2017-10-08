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
	    $file->project_id = 1;
	    $file->filename = 'somefile.pdf';
	    $file->metadata = 'Some metadata';
	    $file->contents = 'Example contents';
	    $file->save();

	    $file = new File();
	    $file->project_id = 2;
	    $file->filename = 'somefile2.pdf';
	    $file->metadata = 'Some metadata';
	    $file->contents = 'Example contents';
	    $file->save();
    }
}
