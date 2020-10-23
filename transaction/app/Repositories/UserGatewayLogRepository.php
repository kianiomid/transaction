<?php
/**
 * Created by PhpStorm.
 * User: omid
 */

namespace App\Repositories;

use App\Models\Currency;
use App\Models\UserGatewayLog;
use Illuminate\Container\Container as Application;

class UserGatewayLogRepository extends BaseRepository
{

    private static $instance = null;

    /**
     * @param Application $app
     * @param null $entityManager
     * @return UserGatewayLogRepository|null
     */
    public static function createInstance(Application $app, $entityManager = null)
    {
        if (!self::$instance) {
            self::$instance = new UserGatewayLogRepository($app, new UserGatewayLog(), $entityManager);
        }
        return self::$instance;
    }

    /**
     * @param $paymentinfo
     * @return mixed
     */
    public function findByGatewayResult($paymentinfo)
    {
        $q = UserGatewayLog::whereGatewayResult($paymentinfo)->firstOrFail();

        return $q;
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
