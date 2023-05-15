<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed email
 */
class Newspaper extends Model
{
    use HasFactory;

    protected $table = 'news';
}
