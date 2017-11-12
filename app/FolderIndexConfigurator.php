<?php

namespace App;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class FolderIndexConfigurator extends IndexConfigurator
{
    use Migratable;


    protected $settings = [
        //
    ];

    protected $defaultMapping = [
    ];
}