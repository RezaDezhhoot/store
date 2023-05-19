<?php

namespace App\Models;

use App\Traits\Admin\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

/**
 * @property mixed created_at
 * @method static latest(string $string)
 * @method static findOrFail($id)
 * @method static where(array $array)
 */
class Article extends Model
{
    use HasFactory , Searchable;

    protected $searchAbleColumns = ['title','slug'];

    const SHARED = 'shared';
    const DEMO = 'demo';

    public $appends = ['day','month'];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public static function getStatus()
    {
        return [
            self::SHARED => 'منتشر شده',
            self::DEMO => 'پیشنویش',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setSlugAttribute($value)
    {
        return $this->attributes['slug'] = Str::slug($value);
    }

    public function getDateAttribute()
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y');
    }

    public function getDayAttribute()
    {
        return Jalalian::forge($this->created_at)->format('%d');
    }

    public function getMonthAttribute()
    {
        return Jalalian::forge($this->created_at)->format('%B');
    }

    public function scopePublished($q)
    {
        return $q->where('status',self::SHARED);
    }
}
