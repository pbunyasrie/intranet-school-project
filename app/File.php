<?php

namespace App;

use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use Searchable;

    protected $indexConfigurator = FileIndexConfigurator::class;

    protected $searchRules = [
        FileContentsSearchRule::class,
        FileMetadataSearchRule::class,
        FileFilenameSearchRule::class
    ];

    protected $mapping = [
        'properties' => [
            'id' => [
                'type' => 'integer',
                'index' => 'not_analyzed'
            ],
	        'project_id' => [
                'type' => 'integer',
                'index' => 'not_analyzed'
            ],
            'filename' => [
                'type' => 'string',
                'analyzer' => 'english'
            ],
            'extension' => [
                'type' => 'string',
                'analyzer' => 'english'
            ],
            'metadatas' => [
                'type' => 'string',
                'analyzer' => 'english'
            ],
            'contents' => [
                'type' => 'string',
                'analyzer' => 'english'
            ]
        ]
    ];


    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize array...

        return $array;
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
