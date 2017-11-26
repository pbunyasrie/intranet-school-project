<?php

namespace App;
use App\User;
use App\FolderAccessUser;
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


    public function files()
    {
        return $this->hasMany('App\File');
    }

    public function usersAccess(){
        return $this->manyThroughMany('App\User', 'App\FolderAccessUser', 'folder_id', 'id', 'user_id');
    }

    public function usersWithAccess()
    {
        $users = $this->usersAccess()->get();
        $siteManagers = User::getUsersByRole("Site Manager")->values();

        return $users->merge($siteManagers);
    }

    public function usersWithNoAccess()
    {
        return User::all()->whereNotIn('id', $this->usersWithAccess()->pluck('id')->toArray());
    }

    public function getLastUpdatedAttribute(){
        if($this->files()->count() > 0){
            return $this->files()->get()->sortByDesc('updated_at')->pluck('updated_at')->first();    
        }

        return $this->created_at;
        
    }

    public function manyThroughMany($related, $through, $firstKey, $secondKey, $pivotKey)
    {
        $model = new $related;
        $table = $model->getTable();
        $throughModel = new $through;
        $pivot = $throughModel->getTable();

        return $model
            ->join($pivot, $pivot . '.' . $pivotKey, '=', $table . '.' . $secondKey)
            ->select($table . '.*')
            ->where($pivot . '.' . $firstKey, '=', $this->id);
    }
}
