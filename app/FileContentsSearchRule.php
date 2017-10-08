<?php

namespace App;

use ScoutElastic\SearchRule;

class FileContentsSearchRule extends SearchRule
{
    public function buildQueryPayload()
    {
  		return [
            'must' => [
                'match' => [
                    'contents' => $this->builder->query,
                ]
            ]
        ];        
    }
}