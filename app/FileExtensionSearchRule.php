<?php

namespace App;

use ScoutElastic\SearchRule;

class FileExtensionSearchRule extends SearchRule
{
    public function buildQueryPayload()
    {
  		return [
            'must' => [
                'match' => [
                    'extension' => $this->builder->query,
                ]
            ]
        ];        
    }
}