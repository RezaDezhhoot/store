<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed country
 * @property mixed province
 * @property mixed city
 * @property mixed address
 * @property mixed status
 * @property mixed postal_code
 * @property mixed name
 * @property mixed phone
 * @property mixed active
 * @property mixed user_id
 * @method static where(string $string, string $NEW)
 * @method static findOrFail($id)
 * @method static create(string[] $array)
 */
class Address extends Model
{
    use HasFactory;

    use HasFactory;

    const CONFIRMED = 'confirmed' , NOT_CONFIRMED  = 'not_confirmed' , NEW = 'new';

    protected $guarded = [];
    public  function getFullAddressAttribute()
    {
        return $this->country.' - '.$this->province.' - '.$this->city.' - '.$this->address;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getStatus()
    {
        return [
            self::CONFIRMED => 'تایید شده',
            self::NOT_CONFIRMED => 'تایید نشده',
            self::NEW => 'جدید',
        ];
    }

    public function getProvinceLabelAttribute()
    {
        return Setting::getProvince()[$this->province];
    }

    public function getCityLabelAttribute()
    {
        return Setting::getCity()[$this->province][$this->city];
    }

    public static function getNew()
    {
        return Address::where('status',self::NEW)->count();
    }

}
