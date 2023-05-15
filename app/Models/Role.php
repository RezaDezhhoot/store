<?php

namespace App\Models;


use App\Traits\Admin\Searchable;

/**
 * @method static whereNotIn(string $string, string[] $array)
 */
class Role extends \Spatie\Permission\Models\Role
{
    use  Searchable;
    protected static $logAttributes = ['*'];
    protected static $dontLogIfAttributesChangedOnly = ['updated_at'];
    protected static $logOnlyDirty = true;
    protected $searchAbleColumns = ['name'];
    protected $fillable = ['name'];
    protected $attributes = [
        'guard_name' => 'web',
    ];
}
