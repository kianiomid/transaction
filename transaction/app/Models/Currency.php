<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    const TABLE = 'tr_currencies';

    public $timestamps = false;

    protected $table = self::TABLE;

    protected $fillable = ["name", "descriptor", "sign", "enable"];

    protected static $selectFields = ["id", "name", "descriptor", "sign", "enable"];

    public function __toString()
    {
        return "{$this->name}";
    }
}
