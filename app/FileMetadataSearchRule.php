<?php

namespace App;

use ScoutElastic\SearchRule;

class FileMetadataSearchRule extends SearchRule
{
    public function buildQueryPayload()
    {
  		return [
            'must' => [
                'match' => [
                    'metadata' => $this->builder->query,
                ]
            ]
        ];        
    }
}