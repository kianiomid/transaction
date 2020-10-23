<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserAccountSetting extends Model
{
    const TABLE = 'tr_user_account_settings';

    protected $table = self::TABLE;

    public $timestamps = false;

    protected $fillable = ["user_id", "country_id", "account_balance", "auto_pay_invoices", "default_timezone"];

    protected static $selectFields = ["id", "user_id", "country_id", "account_balance", "auto_pay_invoices", "default_timezone"];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function __toString()
    {
        return $this->user->name;
    }
}
