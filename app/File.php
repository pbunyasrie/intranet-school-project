<?php

namespace App;

use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['project_id', 'filename', 'filepath', 'contents', 'metadata'];

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
