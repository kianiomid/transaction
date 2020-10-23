<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BGenerator\WebController;
use App\Repositories\UserRepository;

class CurrencyController extends WebController
{
    public $configFile = 'currency';

    /**
     * FishTypeController constructor.
     */
    public function __construct()
    {
        parent::__construct($this->configFile);
    }
}
