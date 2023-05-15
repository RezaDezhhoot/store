<?php

namespace App\Models;

use App\Traits\Admin\Searchable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Bavix\Wallet\Interfaces\Confirmable;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Models\Transaction;
use Bavix\Wallet\Traits\CanConfirm;
use Bavix\Wallet\Traits\HasWallet;

/**
 * @property mixed status
 * @method static findOrFail(int|string|null $id)
 * @method static orderBy(string $string)
 * @method static latest(string $string)
 * @method static whereBetween(string $string, string[] $array)
 * @method static where(string $string, $phone)
 * @method static create(array $array)
 */
class User extends Authenticatable implements Wallet, Confirmable
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles , HasWallet, CanConfirm , Searchable;

    protected $guarded = [];
    const NOT_CONFIRMED = 'not_confirmed';
    const NEW = 'new';
    const CONFIRMED = 'confirmed';

    protected $searchAbleColumns = ['user_name','phone'];

    public static function getStatus()
    {
        return [
            self::NEW => 'جدید',
            self::NOT_CONFIRMED => 'تایید نشده',
            self::CONFIRMED => 'تایید شده',
        ];
    }


    public function getStatusLabelAttribute()
    {
        return self::getStatus()[$this->status];
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function alerts()
    {
        return $this->hasMany(Notification::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }


    public static function getNew()
    {
        return User::where('status',self::NEW)->orWhere('status',self::NOT_CONFIRMED)->count();
    }

    public function schedule()
    {
        return $this->hasOne(Schedule::class);
    }

    public function overtimes(){
        return $this->hasMany(Overtime::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
