<?php

namespace App;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class FileIndexConfigurator extends IndexConfigurator
{
    use Migratable;


    protected $settings = [
        //
    ];

    protected $defaultMapping = [
    ];
}