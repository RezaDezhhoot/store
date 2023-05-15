<?php

namespace App\Http\Livewire\Site\Carts;

use App\Http\Livewire\BaseComponent;
use App\Http\Livewire\Cart\Facades\Cart;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment as Pay;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\Setting;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderNote;
use App\Models\Payment;
use App\Models\Product;
use App\Sends\SendMessages;
use App\Traits\Admin\TextBuilder;
class IndexCheckout extends BaseComponent
{
    use TextBuilder;
    public $data;
    public $isSuccessful, $message;
    public $gateway , $Authority ,$tracking;
    public $address , $status , $track_id , $order_id , $token;
    protected $queryString = ['track_id','status','order_id','tracking'];

    public function mount($gateway = null)
    {
        SEOMeta::setTitle('جزییات پرداخت',false);
        OpenGraph::setUrl(url()->current());
        OpenGraph::setTitle('جزییات پرداخت');
        $this->address = [
            'home' => ['link' => route('home') , 'label' => 'خانه'],
            'checkout' => ['link' => '' , 'label' => 'جزییات پرداخت']
        ];
        if (isset($_GET['id']))
            $this->token = $_GET['id'];
        $this->gateway = $gateway;
        $this->getOrder();

        if ($this->data->status != Order::STATUS_NOT_PAID) {
            $this->isSuccessful = true;
            $this->message = 'پرداخت با موفقیت انجام شد با تشکر از خرید شما';
            return;
        }

        if (is_null($this->gateway)) {
            $this->success();
        } else {
            try {
                if ($this->gateway == 'idpay') {
                    $payment = Pay::via($this->gateway)->amount($this->data->total_price)->transactionId($this->token)->verify();
                } else {
                    $payment = Pay::via($this->gateway)->amount($this->data->total_price)->transactionId($this->Authority)->verify();
                }

                $this->success($payment);

            } catch (InvalidPaymentException $exception) {
                if ($this->gateway == 'idpay') {
                    Payment::where('payment_token', $this->token)->update([
                        'status_code' => $exception->getCode(),
                        'status_message' => $exception->getMessage(),
                    ]);
                } else {
                    Payment::where('payment_token', $this->Authority)->update([
                        'status_code' => $exception->getCode(),
                        'status_message' => $exception->getMessage(),
                    ]);
                }

                $this->isSuccessful = false;
                $this->message = $exception->getMessage();
            }
        }

        Cart::destroy();

    }

    private function success($payment = null)
    {

        $this->isSuccessful = true;
        $this->message = 'پرداخت با موفقیت انجام شد با تشکر از خرید شما';

        if (!is_null($payment) && !Payment::where('payment_ref', $payment->getReferenceId())->exists()) {

            if ($this->gateway == 'idpay') {
                Payment::where('payment_token', $this->token)->update([
                    'payment_ref' => $payment->getReferenceId(),
                    'status_code' => '100',
                    'status_message' => 'پرداخت با موفقیت انجام شد',
                ]);
            } else {
                Payment::where('payment_token', $this->Authority)->update([
                    'payment_ref' => $payment->getReferenceId(),
                    'status_code' => '100',
                    'status_message' => 'پرداخت با موفقیت انجام شد',
                ]);
            }

            foreach ($this->data->details as $detail) {
                OrderNote::create([
                    'note' => 'پرداخت با موفقیت انجام شد. کد پیگیری درگاه: ' . $payment->getReferenceId(),
                    'is_user_note' => 1,
                    'is_read' => 0,
                    'order_id' => $detail->id,
                ]);
            }

        }
        if ($this->data->wallet_pay > 0)
            auth()->user()->forceWithdraw($this->data->wallet_pay, ['description' => 'بابت سفارش ' . $this->data->tracking_code]);

        $score = 0;
        foreach ($this->data->details as $detail) {
            $detail->status = Order::STATUS_COMPLETED;
            $detail->save();
            $product = Product::find($detail->product_id);

            $score += $product->score;

            if (!is_null($product->quantity)) {
                $product->quantity = max($product->quantity - $detail->quantity, 0);
            }

            $product->save();
        }
    }


    public function render()
    {
        return view('livewire.site.carts.index-checkout')
            ->extends('livewire.site.layouts.site.site');
    }

    private function getOrder()
    {
        if ($this->gateway == 'zarinpal') {
            $transaction = Payment::where('payment_gateway', 'zarinpal')
                ->where('payment_token', $this->Authority)
                ->where('model_type', 'order')
                ->where('user_id', auth()->id())
                ->firstOrFail();

            $this->data = Order::with('details.product')
                ->where('user_id', auth()->id())->where('id', $transaction->model_id)->firstOrFail();
        } elseif ($this->gateway == 'idpay') {
            $transaction = Payment::where('payment_gateway', 'idpay')
                ->where('payment_token', $this->token)
                ->where('model_type', 'order')
                ->firstOrFail();

            $this->data = Order::with('details.product')
                ->where('user_id', auth()->id())->where('id', $transaction->model_id)->firstOrFail();
        } else {
            $this->data = Order::with('details.product')->where('user_id', auth()->id())
                ->where('total_price', 0)
                ->where('id', $this->tracking - Order::CHANGE_ID)->firstOrFail();
        }
    }
}
