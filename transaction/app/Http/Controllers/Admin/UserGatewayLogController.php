<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BGenerator\WebController;
use App\Repositories\UserRepository;

class UserGatewayLogController extends WebController
{
    public $configFile = 'user_gateway_log';

    /**
     * FishTypeController constructor.
     */
    public function __construct()
    {
        parent::__construct($this->configFile);
    }
}
