<?php

namespace App\Models;

use App\Traits\Admin\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

/**
 * @property mixed discount_starts_at
 * @property mixed discount_expires_at
 * @property mixed discount_amount
 * @property mixed status
 * @property mixed price
 * @property mixed start_at
 * @property mixed expire_at
 * @property mixed discount_type
 * @property mixed is_active_discount
 * @property mixed title
 * @property mixed slug
 * @property mixed|null short_description
 * @property mixed|null description
 * @property mixed|null quantity
 * @property array|mixed image
 * @property mixed|null media
 * @property mixed score
 * @property false|mixed|string form
 * @property mixed category_id
 * @property mixed seo_description
 * @property mixed seo_keyword
 * @property mixed guarantee
 * @property mixed id
 * @property mixed|null details
 * @method static latest(string $string)
 * @method static findOrFail($id)
 * @method static withCount(string $string)
 * @method static whereIn(string $string, array $ids)
 * @method static where(string $string, $license)
 * @method static find(string $int)
 */
class Product extends Model
{
    use HasFactory , Searchable;

    protected $guarded = [];

    protected static $logAttributes = ['*'];
    protected static $dontLogIfAttributesChangedOnly = ['updated_at'];
    protected static $logOnlyDirty = true;

    public $searchAbleColumns = ['title','slug'];
    const TYPE_PHYSICAL = 'physical';
    const TYPE_DIGITAL = 'digital';

    const STATUS_DRAFT = 'draft';
    const STATUS_AVAILABLE = 'available';
    const STATUS_UNAVAILABLE = 'unavailable';
    const STATUS_COMING_SOON = 'coming_soon';

    const DISCOUNT_FIXED = 'fixed';
    const DISCOUNT_PERCENTAGE = 'percentage';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function filters()
    {
        return $this->belongsToMany(Filter::class , 'products_has_filters' ,'product_id' ,'filter_id');
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = str_replace(env('APP_URL'), '', $value);
    }

    public function getFormAttribute($value)
    {
        return json_decode($value, true);
    }

    public static function getProductsType()
    {
        return [
            self::TYPE_DIGITAL => 'محصول دیجیتال',
            self::TYPE_PHYSICAL => 'محصول فیزیکی',
        ];
    }

    public function orders()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public static function getStatus()
    {
        return [
            self::STATUS_DRAFT => 'پیش نویس',
            self::STATUS_AVAILABLE => 'موجود',
            self::STATUS_UNAVAILABLE => 'نا موجود',
            self::STATUS_COMING_SOON => 'به زودی',
        ];
    }


    public static function getProductsDiscount()
    {
        return [
            self::DISCOUNT_FIXED => 'مبلغ',
            self::DISCOUNT_PERCENTAGE => 'درصد',
        ];
    }

    public function hasReduction()
    {
        $reduction =  $this->discount_amount;
        $now = Carbon::now();
        $start = $this->start_at ?? null;
        $end = $this->expire_at ?? null;
        if ($reduction > 0){
            if($start == null && $end == null){
                return true;
            } elseif ($start <> null && $end == null) {
                $startDate = Carbon::make($start);
                $startDiff = $now->diff($startDate,false);
                if ($startDiff->format('%r%h') > 0 && $start <> null)
                    return false;
                else return true;
            }elseif ($start == null && $end <> null) {
                $endDate = Carbon::make($end);
                $endDiff = $now->diff($endDate,false);
                if ($endDiff->format('%r%h') <= 0)
                    return false;
                else return true;
            }elseif ($start <> null && $end <> null) {
                $startDate = Carbon::make($start);
                $endDate = Carbon::make($end);
                $startDiff = $now->diff($startDate,false);
                $endDiff = $now->diff($endDate,false);
                if ($startDiff->format('%r%h') <= 0 && $endDiff->format('%r%h') >= 0)
                    return true;
                else return false;
            }
        } else {
            return false;
        }
    }

    public function setReductionPrice()
    {
        $amount = 0;
        if ($this->discount_type == self::DISCOUNT_PERCENTAGE)
            $amount = $this->basePrice() - ($this->basePrice()*$this->discount_amount)/100;
        else if ($this->discount_type == self::DISCOUNT_FIXED) $amount = $this->basePrice() - $this->discount_amount;
        else $amount = $this->basePrice();

        return max($amount, 0);
    }

    public function price()
    {
        $price = $this->price;
        if ($this->hasReduction()) {
            $price = $this->setReductionPrice();
        }
        return
            max($price, 0);
    }

    public function basePrice()
    {
        return $this->price ?? 0;
    }


    public function getStatusLabelAttribute()
    {
        return self::getStatus()[$this->status];
    }

}
