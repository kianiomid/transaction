<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BGenerator\WebController;

class UserBalanceLogController extends WebController
{
    public $configFile = 'user_balance_log';

    /**
     * FishTypeController constructor.
     */
    public function __construct()
    {
        parent::__construct($this->configFile);
    }
}
