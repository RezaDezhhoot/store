<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrfail($id)
 * @method static where(string $string, $id)
 */
class Overtime extends Model
{
    use HasFactory;

    public function mangers()
    {
        return $this->belongsTo(User::class,'manger','id');
    }
}
