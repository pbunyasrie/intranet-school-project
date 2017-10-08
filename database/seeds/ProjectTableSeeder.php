<?php

use Illuminate\Database\Seeder;
use App\Project;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project = new Project();
	    $project->id = 1;
	    $project->name = 'Project 1';
	    $project->description = 'Project 1 desc';
	    $project->save();

	    $project = new Project();
	    $project->id = 2;
	    $project->name = 'Project 2';
	    $project->description = 'Project 2 desc';
	    $project->save();
    }
}
