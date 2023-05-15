<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

/**
 * @method static where(string $string, string $NEW)
 * @method static findOrFail($id)
 * @method static latest(string $string)
 * @property mixed created_at
 * @property mixed status
 * @property mixed images
 * @property mixed content
 * @property mixed order
 * @property mixed order_id
 * @property mixed card_number
 * @property mixed sheba_number
 * @property mixed name
 * @property int|mixed quantity
 * @property mixed result
 */
class Refund extends Model
{
    use HasFactory;

    const NEW = 'new'   , ACCEPTED = 'accepted' , REJECT = 'reject';

    public static function getStatus()
    {
        return [
            self::NEW => 'جدید',
            self::ACCEPTED => 'تایید شده',
            self::REJECT => 'رد شده',
        ];
    }

    public function order()
    {
        return $this->belongsTo(OrderDetail::class,'order_id');
    }

    public static function getNew()
    {
        return Refund::where('status',self::NEW)->count();
    }

    public function getDateAttribute()
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y');
    }

    public function getStatusLabelAttribute()
    {
        return self::getStatus()[$this->status];
    }
}
