<?php

namespace App\Http\Controllers;

use App\Repositories\BaseRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use InfyOm\Generator\Utils\ResponseUtil;
use Response;

class AppBaseController extends Controller
{

    public $client;
    public $cultureId;
    public $cultureDesc;
    public $currentDateTime;
    public $currentDate;
    public $entityManager;

    private $currentUserObj;
    protected $currentUser;

    public function __construct()
    {
        $this->cultureId = Config::get('app.culture_id');
        $this->cultureDesc = Config::get('app.culture');
        $this->currentDate = date('Y-m-d');
        $this->entityManager = Config::get('app.ENTITY_MANAGER_ELOQUENT', BaseRepository::MODE_PRODUCTION);
    }

    public function sendResponse($result, $message)
    {
        return response()->json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return response()->json(ResponseUtil::makeError($error), $code);
    }

    public function loadCurrentUser(Request $request = null)
    {
        $this->currentUser = $this->getCurrentUser($request);
    }

    public function getCurrentUser(Request $request = null)
    {

        if ($request == null) {
            $request = request();
        }

        $userId = Config::get('app.CURRENT_USER_FOR_TEST', null);
        if ($userId != null) {
            $this->currentUserObj = User::find($userId);
        } else {
            if (!$this->currentUserObj) {

                if (Config::get('app.SESSION_SHARING_ENABLE')) {
                    $this->currentUserObj = $this->findCurrentUser($request);
                } else {
                    $this->currentUserObj = auth()->user();
                }


            }
        }

        return $this->currentUserObj;

    }

    private function findCurrentUser(Request $request)
    {
        $user = UserRepository::createInstance(app(), $this->entityManager)
            ->find($request->attributes->get('current_user_id'));

        if ($user)
            return $user;

        return abort(403);
    }
}
