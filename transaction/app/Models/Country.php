<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    const TABLE = 'tr_countries';

    protected $table = self::TABLE;

    public $timestamps = false;

    protected $fillable = [ "currency_id", "name", "descriptor", "abbreviation", "week_holidays", "default_timezone", "enable"];

    protected static $selectFields = ["id", "currency_id", "name", "descriptor", "abbreviation", "week_holidays", "default_timezone", "enable"];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function __toString()
    {
        return "{$this->name}";
    }
}
