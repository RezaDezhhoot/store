<?php

namespace App\Models;

use App\Traits\Admin\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed type
 * @method static where(array[] $array)
 * @method static findOrFail($id)
 * @method static whereNotNull(string $string)
 * @method static find($category_id)
 * @method static withCount(string $string)
 * @method static whereNull(string $string)
 */
class Category extends Model
{
    use HasFactory , Searchable;

    protected $searchAbleColumns = ['title','slug'];

    const AVAILABLE = 'available' , UNAVAILABLE = 'unavailable';

    const PRODUCT = 'products' , ARTICLE = 'articles';

    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }

    public static function getStatus()
    {
        return [
            self::AVAILABLE => 'فعال',
            self::UNAVAILABLE => 'غیر فعال',
        ];
    }

    public static function type()
    {
        return [
            self::PRODUCT => 'محصول ',
            self::ARTICLE => 'مقاله ',
        ];
    }

    public function child()
    {
        return $this->hasMany(Category::class,'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->child()->with('childrenRecursive');
    }

    public function groups()
    {
        return $this->hasMany(FilterGroup::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }



    public function getTypeLabelAttribute()
    {
        return self::type()[$this->type];
    }
}
