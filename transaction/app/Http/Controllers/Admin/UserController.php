<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BGenerator\WebController;
use App\Repositories\UserRepository;

class UserController extends WebController
{
    public $configFile = 'user';

    /**
     * FishTypeController constructor.
     */
    public function __construct()
    {
        parent::__construct($this->configFile);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function autoComplete()
    {
        $q = request()->get('q');

        $items = UserRepository::createInstance(app())
            ->getForAutocomplete($q);

        return response()->json([
            'results' => $items,
        ]);
    }
}
