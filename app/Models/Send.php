<?php

namespace App\Models;

use App\Traits\Admin\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static latest(string $string)
 * @method static findOrFail($id)
 * @method static where(string $string, string $AVAILABLE)
 * @method static find($transfer_id)
 * @method static getStatus()
 * @property mixed slug
 * @property mixed logo
 * @property mixed send_time_inner_city
 * @property mixed send_time_outer_city
 * @property mixed note
 * @property int|mixed pursuit
 * @property mixed status
 * @property mixed pursuit_web_site
 * @property mixed price
 */
class Send extends Model
{
    use HasFactory , Searchable;
    protected $searchAbleColumns = ['slug'];

}
