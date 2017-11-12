<?php

namespace App;

use ScoutElastic\SearchRule;

class FolderDescriptionSearchRule extends SearchRule
{
    public function buildQueryPayload()
    {
  		return [
            'must' => [
                'match' => [
                    'description' => $this->builder->query,
                ]
            ]
        ];        
    }
}