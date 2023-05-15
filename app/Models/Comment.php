<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

/**
 * @method static where(string $string, string $NEW)
 * @method static latest($id)
 * @method static findOrFail($id)
 * @method static find($id)
 * @method static create(array $array)
 * @property mixed status
 * @property mixed commentable_type
 * @property mixed comment
 * @property mixed answer
 * @property mixed rating
 * @property mixed created_at
 * @property mixed updated_at
 */
class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    const CONFIRMED = 'confirmed' , UNCONFIRMED = 'unconfirmed' , NEW = 'new';

    const ARTICLE = 'App\Models\Article' , PRODUCT = 'App\Models\Product';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function type()
    {
        return [
            self::ARTICLE => 'مقاله',
            self::PRODUCT => 'محصول',
        ];
    }

    public function commentable()
    {
        return $this->morphTo(__FUNCTION__, 'commentable_type', 'commentable_id');
    }

    public function getCommentableTypeLabelAttribute()
    {
        if ($this->commentable_type == self::ARTICLE) {
            return self::ARTICLE;
        } elseif ($this->commentable_type == self::PRODUCT) {
            return self::PRODUCT;
        }
    }

    public static function getStatus()
    {
        return [
            self::CONFIRMED => 'تایید شده',
            self::UNCONFIRMED => 'تایید نشده',
            self::NEW => 'جدید',
        ];
    }

    public function getStatusLabelAttribute()
    {
        return self::getStatus()[$this->status];
    }

    public function getDateAttribute()
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y');
    }

    public function getUpdateDateAttribute()
    {
        return Jalalian::forge($this->updated_at)->format('%A, %d %B %Y');
    }

    public static function getNew()
    {
        return Comment::where('status',self::NEW)->count();
    }
}
