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

class CountryRepository extends BaseRepository
{

    private static $instance = null;

    /**
     * @param Application $app
     * @param null $entityManager
     * @return CountryRepository|null
     */
    public static function createInstance(Application $app, $entityManager = null)
    {
        if (!self::$instance) {
            self::$instance = new CountryRepository($app, new Country(), $entityManager);
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
