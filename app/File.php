<?php

namespace App;

use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;
use ScoutElastic\IndexConfigurator;

class File extends Model
{
    protected $fillable = ['folder_id', 'filename', 'filepath', 'contents', 'metadata', 'extension'];

    use Searchable;

    protected $indexConfigurator = FileIndexConfigurator::class;


    // You can set several rules for one model. In this case, the first not empty result will be returned.
    protected $searchRules = [
        FileContentsSearchRule::class,
        FileMetadataSearchRule::class,
        FileFilenameSearchRule::class
    ];

    // https://www.elastic.co/guide/en/elasticsearch/reference/current/analysis-analyzers.html
    protected $mapping = [
        'properties' => [
            'id' => [
                'type' => 'integer',
                'index' => 'not_analyzed'
            ],
	        'folder_id' => [
                'type' => 'integer',
                'index' => 'not_analyzed'
            ],
            'filename' => [
                'type' => 'string',
                'analyzer' => 'simple'
            ],
            'filepath' => [
                'type' => 'text',
                'index' => 'not_analyzed'
            ],
            'extension' => [
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

    public function folder()
    {
        return $this->belongsTo('App\Folder');
    }

    public function getContentsExcerpt($search, $maxLength=100) {
        $str = $this->contents;
        $startPos = stripos($str, $search); // case insensitive
        if(strlen($str) > $maxLength) {
            $excerpt   = substr($str, $startPos, $maxLength-3);
            $lastSpace = strrpos($excerpt, ' ');
            $excerpt   = substr($excerpt, 0, $lastSpace);
            $excerpt  .= '...';
        } else {
            $excerpt = $str;
        }
        
        return $excerpt;
    }

}
