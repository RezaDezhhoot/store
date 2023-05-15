<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find($id)
 */
class Filter extends Model
{
    use HasFactory;

    public function group()
    {
        return $this->belongsTo(FilterGroup::class);
    }
}
