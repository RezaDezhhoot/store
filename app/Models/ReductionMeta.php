<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $id)
 * @method static updateOrCreate(array $array, array $array1)
 */
class ReductionMeta extends Model
{
    use HasFactory;

    protected $table = 'reductions_meta';
    protected $guarded = [];
    public $timestamps = false;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
}
