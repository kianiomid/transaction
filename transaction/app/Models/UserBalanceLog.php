<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserBalanceLog extends Model
{
    const TABLE = 'tr_user_balance_logs';

    protected $table = self::TABLE;

    public $timestamps = false;

    protected $fillable = ["user_id", "country_id", "deposit", "payment", "payment_info1", "payment_info2", "reason_info1", "reason_info2"];

    protected static $selectFields = ["id", "user_id", "country_id", "deposit", "payment", "payment_info1", "payment_info2", "reason_info1", "reason_info2"];

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
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function __toString()
    {
        return $this->user->name;
    }
}
