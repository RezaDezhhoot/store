<?php

namespace App\Models;

use App\Traits\Admin\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($id)
 * @method static find($id)
 * @method static where(string $string, $voucherCode)
 */
class Reduction extends Model
{
    use HasFactory;

    use Searchable;

    const TYPE_FIXED = 'fixed';
    const TYPE_PERCENT = 'percent';

    protected static $logAttributes = ['*'];
    protected static $dontLogIfAttributesChangedOnly = ['updated_at'];
    protected static $logOnlyDirty = true;

    public $searchAbleColumns = ['code'];

    public function meta()
    {
        return $this->hasMany(ReductionMeta::class);
    }


    public static function getType()
    {
        return [
            self::TYPE_FIXED => 'مبلغ',
            self::TYPE_PERCENT => 'درصد',
        ];
    }
}
