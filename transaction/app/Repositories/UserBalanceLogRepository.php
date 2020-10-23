<?php
/**
 * Created by PhpStorm.
 * User: omid
 */

namespace App\Repositories;

use App\Models\Currency;
use App\Models\UserBalanceLog;
use Illuminate\Container\Container as Application;

class UserBalanceLogRepository extends BaseRepository
{

    private static $instance = null;

    /**
     * @param Application $app
     * @param null $entityManager
     * @return UserBalanceLogRepository|null
     */
    public static function createInstance(Application $app, $entityManager = null)
    {
        if (!self::$instance) {
            self::$instance = new UserBalanceLogRepository($app, new UserBalanceLog(), $entityManager);
        }
        return self::$instance;
    }

    /**
     * @param null $item
     * @param null $parentItem
     * @return mixed
     */
    public function AdminSelectCurrency($item = null, $parentItem = null)
    {
        return Currency::get();
    }
}
