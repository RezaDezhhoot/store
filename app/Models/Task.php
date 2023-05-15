<?php

namespace App\Models;

use App\Traits\Admin\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static latest(string $string)
 * @method static findOrFail($id)
 * @method static where(string $string, $task)
 * @property mixed name
 * @property array|mixed task
 * @property mixed where
 * @property mixed value
 */
class Task extends Model
{
    use HasFactory ,Searchable;
    protected $searchAbleColumns = ['name'];

    public static function event()
    {
        return [
            'sms' => 'SMS',
            'notification' => 'NOTIFICATION',
//            'sms_email' => 'SMS & EMAIL',
            'sms_notification' => 'SMS & NOTIFICATION',
//            'email_notification' => 'EMAIL & NOTIFICATION',
//            'sms_email_notification' => 'SMS & EMAIL & NOTIFICATION',
        ];
    }

    public static function tasks()
    {
        return [
            'confirm_address' => 'تایید ادرس',#ok
            'reject_address' => 'رد ادرس',#ok
            'login' => 'ورود به حساب کاربری',
            'signUp'=> 'ثبت نام',
            'auth'=> 'تکمیل احراز هویت',#ok
            'not_confirmed' => 'رد حساب کاربری',#ok
            'new_ticket' => 'تیکت جدید',#ok
            'ticket_answer' => 'پاسخ تیکت',#ok
            'new_message' => 'پیام جدید',
            'order_on_hold' => 'در انتظار بررسی توسط پشتیبانی',
            'order_wc_processing' => 'در حال انجام توسط تیم ثبت سفارشات',
            'order_wc_custom_status' => 'درحال آماده سازی در انبار',
            'order_wc_post' => 'ارسال شده ',
            'order_wc_cancelled' => 'در انتظار بازگشت وجه',
            'order_wc_refunded_req' => 'درخواست مرجوعیت',
            'order_wc_refunded_rej' => 'رد درخواست مرجوعیت',
            'order_wc_refunded' => 'مرجوع شده',
            'order_wc_completed' => 'تکمیل شده',
        ];
    }
}
