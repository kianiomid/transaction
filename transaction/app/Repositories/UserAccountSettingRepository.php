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

class UserAccountSettingRepository extends BaseRepository
{

    private static $instance = null;

    /**
     * @param Application $app
     * @param null $entityManager
     * @return UserAccountSettingRepository|null
     */
    public static function createInstance(Application $app, $entityManager = null)
    {
        if (!self::$instance) {
            self::$instance = new UserAccountSettingRepository($app, new UserAccountSetting(), $entityManager);
        }
        return self::$instance;
    }

    /**
     * @param null $item
     * @param null $parentItem
     * @return mixed
     */
    public function AdminSelectCountry($item = null, $parentItem = null)
    {
        return Country::get();
    }

    /**
     * @param $options
     */
    public function updateAccountBalance($options)
    {
        $userAccountSetting = $this->findByUserId($options['userId']);

        if (isset($options['deposit'])) {
            $userAccountSetting->account_balance += $options['deposit'];

        }
        $userAccountSetting->save();

        $ubl = new UserBalanceLog();
        $ubl->setAttribute('user_id', $options['userId']);
        $ubl->setAttribute('deposit', isset($options['deposit']) ? $options['deposit'] : null);
        $ubl->setAttribute('payment', isset($options['payment']) ? $options['payment'] : null);
        $ubl->setAttribute('currency_id', $options['currencyId']);
        $ubl->setAttribute('payment_info1', isset($options['refId']) ? $options['refId'] : null);
        $ubl->setAttribute('payment_info2', isset($options['paymentType']) ? $options['paymentType'] : null);
        $ubl->setAttribute('reason_info1', '');
        $ubl->setAttribute('reason_info2', '');
        $ubl->save();
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function findByUserId($userId)
    {
        $q = UserAccountSetting::whereUserId($userId)
            ->firstOrFail();

        return $q;
    }
}
