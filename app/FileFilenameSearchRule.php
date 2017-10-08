<?php

namespace App;

use ScoutElastic\SearchRule;

class FileFilenameSearchRule extends SearchRule
{
    public function buildQueryPayload()
    {
  		return [
            'must' => [
                'match' => [
                    'filename' => $this->builder->query,
                ]
            ]
        ];        
    }
}