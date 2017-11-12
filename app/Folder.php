<?php

namespace App;

use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;
use ScoutElastic\IndexConfigurator;

class Folder extends Model
{
    use Searchable;

    protected $indexConfigurator = FolderIndexConfigurator::class;

	// You can set several rules for one model. In this case, the first not empty result will be returned.
    protected $searchRules = [
        FolderDescriptionSearchRule::class,
        FolderNameSearchRule::class
    ];

    public function files()
    {
        return $this->hasMany('App\File');
    }

     // https://www.elastic.co/guide/en/elasticsearch/reference/current/analysis-analyzers.html
    protected $mapping = [
        'properties' => [
            'id' => [
                'type' => 'integer',
                'index' => 'not_analyzed'
            ],
            'name' => [
                'type' => 'string',
                'analyzer' => 'simple'
            ],
            'description' => [
                'type' => 'string',
                'analyzer' => 'simple'
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
}
