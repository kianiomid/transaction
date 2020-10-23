<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BGenerator\WebController;
use App\Repositories\UserRepository;

class UserAccountSettingController extends WebController
{
    public $configFile = 'user_account_setting';

    /**
     * FishTypeController constructor.
     */
    public function __construct()
    {
        parent::__construct($this->configFile);
    }
}
