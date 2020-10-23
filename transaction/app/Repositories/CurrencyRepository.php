<?php
/**
 * Created by PhpStorm.
 * User: omid
 */

namespace App\Repositories;

use App\Models\Country;
use App\Models\Currency;
use App\Models\UserAccountSetting;
use App\Models\UserBalanceLog;
use Illuminate\Container\Container as Application;

class CurrencyRepository extends BaseRepository
{

    private static $instance = null;

    /**
     * @param Application $app
     * @param null $entityManager
     * @return CurrencyRepository|null
     */
    public static function createInstance(Application $app, $entityManager = null)
    {
        if (!self::$instance) {
            self::$instance = new CurrencyRepository($app, new CurrencyRepository(), $entityManager);
        }
        return self::$instance;
    }
}
