<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BGenerator\WebController;
use App\Repositories\UserRepository;

class CountryController extends WebController
{
    public $configFile = 'country';

    /**
     * FishTypeController constructor.
     */
    public function __construct()
    {
        parent::__construct($this->configFile);
    }
}
