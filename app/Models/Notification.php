<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

/**
 * @property mixed created_at
 * @property mixed subject
 * @property mixed|null model_id
 * @property mixed model
 * @property mixed content
 * @property mixed type
 * @property mixed user_id
 * @method static findOrFail($id)
 * @method static latest(string $string)
 */
class Notification extends Model
{
    use HasFactory;
    const PUBLIC = 'public' , PRIVATE = 'private';

    const ORDER = 'Order' , AUTH = 'Auth' , ADDRESS = 'Address' ;
    const TICKET = 'Ticket' , ALL = 'All' , SECURITY = 'Security' , User = 'User';

    public static function getSubject()
    {
        return [
            self::ORDER => 'اگهی ها',
            self::AUTH => ' احراز هویت',
            self::User => 'حساب کاربری',
            self::ADDRESS => 'ادرس',
            self::TICKET => 'تیکت',
            self::SECURITY => 'امنیتی',
            self::ALL => 'عمومی',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSubjectLabelAttribute()
    {
        return self::getSubject()[$this->subject];
    }

    public static function getType()
    {
        return [
            self::PRIVATE => 'خصوصی',
            self::PUBLIC => 'عمومی',
        ];
    }

    public function getDateAttribute()
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y');
    }


}
