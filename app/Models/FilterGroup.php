<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find($key)
 */
class FilterGroup extends Model
{
    protected $table = 'filters_group';
    use HasFactory;

    public function filters()
    {
        return $this->hasMany(Filter::class,'group_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
