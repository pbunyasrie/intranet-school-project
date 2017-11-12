<?php

namespace App;

use ScoutElastic\SearchRule;

class FolderNameSearchRule extends SearchRule
{
    public function buildQueryPayload()
    {
  		return [
            'must' => [
                'match' => [
                    'name' => $this->builder->query,
                ]
            ]
        ];        
    }
}