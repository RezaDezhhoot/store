<?php

namespace App\Models;

use App\Traits\Admin\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

/**
 * @property mixed id
 * @property mixed details
 * @property mixed status
 * @property mixed created_at
 * @method static latest(string $string)
 * @method static findOrFail($id)
 * @method static whereBetween(string $string, string[] $array)
 * @method static create(array $array)
 * @method static where(string $string, int|string|null $id)
 * @method static find($order_id)
 */
class Order extends Model
{
    use HasFactory , Searchable;

    const CHANGE_ID = 897879;
    const STATUS_NOT_PAID = 'wc-pending';
    const STATUS_HOLD = 'wc-on-hold';
    const STATUS_PROCESSING = 'wc-processing';
    const STATUS_STORE = 'wc-custom-status';
    const STATUS_POST = 'wc-post';
    const STATUS_CANCELLED = 'wc-cancelled';
    const STATUS_REFUNDED = 'wc-refunded';
    const STATUS_COMPLETED = 'wc-completed';

    protected $guarded = [];
    protected $attributes = [];

    protected static $logAttributes = ['*'];
    protected static $dontLogIfAttributesChangedOnly = ['updated_at'];
    protected static $logOnlyDirty = true;

    public $searchAbleColumns = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function notes()
    {
        return $this->hasMany(OrderNote::class);
    }

    public function getTrackingCodeAttribute()
    {
        return 'KH-'.($this->id + self::CHANGE_ID);
    }

    public function getStatusAttribute()
    {
        foreach ($this->details as $detail){

            if ($detail->status == Order::STATUS_NOT_PAID){
                return self::STATUS_NOT_PAID;
            }

            if ($detail->status != Order::STATUS_COMPLETED){
                return Order::STATUS_PROCESSING;
            }
        }


        return self::STATUS_COMPLETED;
    }

    public function canComment()
    {
        foreach ($this->details as $detail)

            if (is_null($detail->comment) || empty($detail->comment))
                return true;

        return false;
    }

    public function getStatusLabelAttribute()
    {
        if ($this->status == self::STATUS_NOT_PAID){
            return self::getStatus()[$this->status];
        }

        if ($this->status == self::STATUS_COMPLETED || $this->status == self::STATUS_REFUNDED){
            return self::getStatus()[$this->status];
        }

        return 'در حال انجام';
    }

    public static function getStatus()
    {
        return [
            self::STATUS_NOT_PAID => 'در انتظار پرداخت',
            self::STATUS_HOLD => 'در انتظار بررسی توسط پشتیبانی',
            self::STATUS_PROCESSING => 'در حال انجام توسط تیم ثبت سفارشات',
            self::STATUS_STORE => 'درحال آماده سازی در انبار',
            self::STATUS_POST => 'ارسال شده',
            self::STATUS_CANCELLED => 'در انتظار بازگشت وجه',
            self::STATUS_REFUNDED => 'مرجوع شده',
            self::STATUS_COMPLETED => 'تکمیل شده',
        ];
    }

    public function send()
    {
        return $this->belongsTo(Send::class);
    }

    public function getDateAttribute()
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y');
    }

    public static function getNew()
    {
        return OrderDetail::where('status',self::STATUS_PROCESSING)->count();
    }

}
