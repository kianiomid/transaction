<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserGatewayLog extends Model
{
    const TABLE = 'tr_user_gateway_logs';

    protected $table = self::TABLE;

    protected $fillable = ["user_id", "currency_id", "price", "gateway_result"];

    protected static $selectFields = ["id", "user_id", "currency_id", "price", "gateway_result"];

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
}
