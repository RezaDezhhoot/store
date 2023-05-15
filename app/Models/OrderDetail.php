<?php

namespace App\Models;

use App\Traits\Admin\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

/**
 * @property mixed status
 * @property mixed created_at
 * @property mixed id
 * @method static where(string $string, string $STATUS_PROCESSING)
 * @method static latest(string $string)
 * @method static findOrFail($id)
 * @method static whereBetween(string $string, string[] $array)
 * @method static create(array $array)
 * @method static find(int|string $id)
 */
class OrderDetail extends Model
{
    use HasFactory;
    use Searchable;

    public $timestamps = false;
    protected $guarded = [];

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public $searchAbleColumns = ['order_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function note()
    {
        return $this->hasMany(OrderNote::class,'order_id');
    }

    public function getProductDataAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getFormAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function getStatusLabelAttribute()
    {
        return Order::getStatus()[$this->status];
    }

    public function getTrackingCodeAttribute()
    {
        return 'KH-'.($this->id + Order::CHANGE_ID);
    }

    public function getDateAttribute()
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y');
    }

    public static function getStatus()
    {
        return  Order::getStatus();
    }

    public function comment()
    {
        return $this->hasOne(Comment::class,'order_id');
    }

    public function refund()
    {
        return $this->hasOne(Refund::class,'order_id');
    }
}
