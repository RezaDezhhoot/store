<?php

namespace App\Http\Livewire\Site\Carts;

use App\Http\Livewire\BaseComponent;
use App\Http\Livewire\FormBuilder\Facades\FormBuilder;
use App\Models\Address;
use App\Models\Category;
use App\Models\Order;
use App\Models\Reduction;
use App\Models\Send;
use App\Models\Setting;
use App\Models\Payment;
use App\Models\OrderDetail;
use App\Models\OrderNote;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Http\Livewire\Cart\Facades\Cart;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;
use Shetabit\Multipay\Exceptions\PurchaseFailedException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment as Pay;

class IndexPayment extends BaseComponent
{
    public $address , $user , $phone , $reductionCode , $data = [] , $name , $province , $city , $fullAddress , $activeAddress , $postal_code ;
    public $description , $cartContent , $sends , $selectedSend = false;
    public $useWallet = false;
    public $walletAmount = 0;
    public $useVoucher = false;
    public $voucherCode;
    public $voucherAmount = 0;
    public $sendAmount = 0;
    public function mount()
    {
        SEOMeta::setTitle('تکمیل خرید',false);
        OpenGraph::setUrl(url()->current());
        OpenGraph::setTitle('تکمیل خرید');
        $this->data['province'] = Setting::getProvince();
        $this->data['city'] = [];
        $this->user = auth()->user();
        $this->name = $this->user->name;
        $this->phone = $this->user->phone;
        $this->activeAddress = $this->user->addresses()->where([
            ['status',Address::CONFIRMED],
            ['active',true]
        ])->first();

        if (!is_null($this->activeAddress) && !empty($this->activeAddress)){
            $this->province = $this->activeAddress->province;
            $this->city = $this->activeAddress->city;
            $this->fullAddress = $this->activeAddress->address;
            $this->postal_code = $this->activeAddress->postal_code;
        }

        $this->sends = Send::all();

        $this->address = [
            'home' => ['link' => route('home') , 'label' => 'خانه'],
            'payment' => ['link' => '' , 'label' => 'تکمیل خرید']
        ];

    }

    public function render()
    {
        $this->cartContent = Cart::content();
        if (isset($this->province) && in_array($this->province,array_keys($this->data['province'])))
            $this->data['city'] = Setting::getCity()[$this->province];

        return view('livewire.site.carts.index-payment')
            ->extends('livewire.site.layouts.site.site');
    }

    public function updatedUseWallet()
    {
        $this->calculatePrice();
    }

    public function updatedSelectedSend()
    {
        $send = Send::find($this->selectedSend);
        if (!empty($send) && !is_null($send)) {
            $this->sendAmount = $send->price;
            $this->calculatePrice();
        } else
            return $this->addError('payment',' روش ارسال معتبر نمی باشد');

    }

    private function calculatePrice()
    {
        $this->walletAmount = 0;
        if ($this->useWallet) {
            $user = auth()->user();

            $balance = $user->balance;
            if ($balance > 0){
                if ($balance >= Cart::total(0, $this->voucherAmount, $this->sendAmount)) {
                    $balance = Cart::total(0, $this->voucherAmount, $this->sendAmount);
                }

                $this->walletAmount = $balance;
            }
        }
    }



    public function checkVoucherCode()
    {
        $this->useVoucher = false;
        $this->voucherAmount = 0;
        $voucher = Reduction::where('code', $this->voucherCode);


        if (!empty($voucher->first()->expires_at))
        {
            $interval = Carbon::make(now())->diff($voucher->first()->expires_at);
            if ((int)$interval->format("%r%a") < 0)
            {
                $this->addError('voucher', 'کد وارد شده  منقضی شده است');
                $this->calculatePrice();
                $this->voucherCode = null;
                return;
            }
        }

        if (!empty($voucher->first()->starts_at))
        {
            $interval = Carbon::make(now())->diff($voucher->first()->starts_at);
            if ((int)$interval->format("%r%a") > 0)
            {
                $this->addError('voucher', 'کد وارد شده معتبر نیست');
                $this->calculatePrice();
                $this->voucherCode = null;
                return;
            }
        }


        //exists
        if (!$voucher->exists()){
            $this->addError('voucher', 'کد وارد شده معتبر نیست');
            $this->calculatePrice();
            $this->voucherCode = null;
            return;
        }



        $voucher = $voucher->first();
        $meta = $voucher->meta;

        if ($meta->contains('name', 'minimum_amount')){
            if (Cart::price() < $meta->where('name', 'minimum_amount')->first()->value){
                $this->addError('voucher', 'مبلغ سفارش کمتر از حد مجاز است');
                $this->calculatePrice();
                $this->voucherCode = null;
                return;
            }
        }

        if ($meta->contains('name', 'maximum_amount')){
            if (Cart::price() > $meta->where('name', 'maximum_amount')->first()->value) {
                $this->addError('voucher', 'مبلغ سفارش بیشتر از حد مجاز است');
                $this->calculatePrice();
                $this->voucherCode = null;
                return;
            }
        }

        if ($meta->contains('name', 'product_ids')){
            foreach (Cart::content() as $item){
                if (!str_contains($meta->where('name', 'product_ids')->first()->value, $item->id)){
                    $this->addError('voucher', 'امکان استفاده روی این محصولات وجود ندارد');
                    $this->calculatePrice();
                    $this->voucherCode = null;
                    return;
                }
            }
        }

        if ($meta->contains('name', 'exclude_product_ids')){
            foreach (Cart::content() as $item){
                if (str_contains($meta->where('name', 'exclude_product_ids')->first()->value, $item->id)){
                    $this->addError('voucher', 'امکان استفاده روی این محصولات وجود ندارد');
                    $this->calculatePrice();
                    $this->voucherCode = null;
                    return;
                }
            }
        }

        if ($meta->contains('name', 'exclude_sale_items')){
            foreach (Cart::content() as $item){
                if ($item->discount() > 0){
                    $this->addError('voucher', 'امکان استفاده روی محصول دارای تخفیف وجود ندارد');
                    $this->calculatePrice();
                    $this->voucherCode = null;
                    return;
                }
            }
        }

        if ($meta->contains('name', 'category_ids')){
            foreach (Cart::content() as $item){
                $product = Product::find($item->id);
                $category = Category::find($product->category_id);
                $parentCategory = $category->parent;
                foreach (explode(',', $meta->where('name', 'category_ids')->first()->value) as $cat){
                    if ((int) $cat != $category->id || (int) $cat != $parentCategory->id){
                        $this->addError('voucher', 'امکان استفاده روی ابن محصولات وجود ندارد');
                        $this->calculatePrice();
                        $this->voucherCode = null;
                        return;
                    }
                }
            }
        }

        if ($meta->contains('name', 'exclude_category_ids')){
            foreach (Cart::content() as $item){
                $product = Product::find($item->id);
                $category = Category::find($product->category_id);
                $parentCategory = $category->parent;
                foreach (explode(',', $meta->where('name', 'exclude_category_ids')->first()->value) as $cat){
                    if ((int) $cat = $category->id || (int) $cat == $parentCategory->id){
                        $this->addError('voucher', 'امکان استفاده روی ابن محصولات وجود ندارد');
                        $this->calculatePrice();
                        $this->voucherCode = null;
                        return;
                    }
                }
            }
        }

        if ($meta->contains('name', 'usage_limit')){
            $count = Order::where('reduction_code', $voucher->code)->count();
            if ($count >= (int) $meta->where('name', 'usage_limit')->first()->value){
                $this->addError('voucher', 'امکان استفاده از کد وجود ندارد');
                $this->calculatePrice();
                $this->voucherCode = null;
                return;
            }
        }

        if ($meta->contains('name', 'usage_limit_per_user')){
            $count = Order::where('reduction_code', $voucher->code)
                ->where('user_id', auth()->id())
                ->count();
            if ($count >= (int) $meta->where('name', 'usage_limit_per_user')->first()->value){
                $this->addError('voucher', 'شما قبلا به میزان مجاز از این کد استفاده کرده اید');
                $this->calculatePrice();
                $this->voucherCode = null;
                return;
            }
        }
        if ($meta->contains('name', 'value_limit')){
            if ($voucher->type == Reduction::TYPE_PERCENT){
                if ( ((Cart::total() * $voucher->amount) / 100) > $meta->where('name', 'value_limit')->first()->value) {
                    $this->useVoucher = true;

                    $this->voucherAmount = $voucher->amount;

                    $this->voucherAmount = $meta->where('name', 'value_limit')->first()->value;

                    $this->calculatePrice();

                    return;
                }
            }
        }


        $this->useVoucher = true;

        $this->voucherAmount = $voucher->amount;
        if ($voucher->type == Reduction::TYPE_PERCENT){
            $this->voucherAmount = (Cart::total() * $voucher->amount) / 100;
        }

        $this->calculatePrice();
    }

    public function payment()
    {
        $this->description = ($this->description == '') ? null : $this->description;

        if (sizeof(Cart::content()) == 0) {
            return redirect()->route('home');
        }

        $this->validate(
            [
                'name' => ['required', 'string', 'max:250'],
                'phone' => ['required', 'string', 'size:11'],
                'description' => ['nullable', 'string', 'max:16500'],
                'province' => ['required', 'max:250' , 'in:'.implode(',',array_keys($this->data['province']))],
                'city' => ['required', 'max:250' , 'in:'.implode(',',array_keys($this->data['city']))],
                'postal_code' => ['required', 'size:10'],
                'fullAddress' => ['required', 'string'],
                'selectedSend' => ['required','exists:sends,id'],
            ],
            [],
            [
                'name' => 'نام',
                'phone' => 'موبایل',
                'description' => 'توضیحات',
                'province' => 'استان',
                'city' => 'شهر',
                'postal_code' => 'کد پستی',
                'fullAddress' => 'ادرس',
                'selectedSend' => 'روش ارسال'
            ]
        );
        if ($this->useVoucher && ! Reduction::where('code', $this->voucherCode)->exists()){
            $this->useVoucher = false;
            $this->voucherCode = null;
            return  $this->addError('voucher', 'کد وارد شده معتبر نیست');
        }

        if (Cart::total($this->walletAmount, $this->voucherAmount , $this->sendAmount) == 0) {
            $orderId = $this->store();
            return redirect(route('checkout', ['tracking' => $orderId + Order::CHANGE_ID]));
        }

        try {
            $payment = Pay::via('idpay')->callbackUrl(env('APP_URL') . '/checkout/idpay')
                ->purchase((new Invoice)
                    ->amount(Cart::total((int)$this->walletAmount, (int)$this->voucherAmount , (int)$this->sendAmount ))
                    ->detail('detailName','your detail goes here'), function ($driver, $transactionId) {
                    $this->store('idpay',$transactionId);
                })->pay()->toJson();

            $payment = json_decode($payment);
            return redirect($payment->action);
        } catch (PurchaseFailedException $exception){
            $this->addError('payment', $exception->getMessage());
        }
    }

    public function store($gateway = null,$transactionId = null)
    {
        $id = DB::transaction(function () use ($gateway, $transactionId) {
            $voucherId = null;
            $voucherAmount = 0;
            if ($this->useVoucher){
                $voucherCode = $this->voucherCode;
                $voucherAmount = $this->voucherAmount;
            }

            if (empty(auth()->user()->addresses->toArray()))
            {
                Address::create([
                    'country' => 'Iran',
                    'province' => $this->province,
                    'city' => $this->city,
                    'address' => $this->fullAddress,
                    'postal_code' => $this->postal_code,
                    'name' => $this->name,
                    'phone' => $this->phone,
                    'status' => Address::CONFIRMED,
                    'user_id' => auth()->id(),
                    'active' => true,
                ]);
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'send_id' => $this->selectedSend,
                'user_ip' => request()->ip(),
                'price' => Cart::price(),
                'total_price' => Cart::total($this->walletAmount, $voucherAmount , $this->sendAmount),
                'reduction_code' => $voucherCode ?? null,
                'reductions_value' => Cart::discount() + $voucherAmount,
                'wallet_pay'=>$this->walletAmount,
                'discount' => Cart::discount(),
                'phone' => $this->phone,
                'name' => $this->name,
                'province'=> $this->province,
                'city' => $this->city,
                'address' => $this->fullAddress,
                'postal_code' => $this->postal_code,
                'description' => $this->description,
                'transactionId' => $transactionId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (!is_null($gateway)) {
                Payment::create([
                    'amount' => Cart::total($this->walletAmount, $voucherAmount,$this->sendAmount),
                    'payment_gateway' => $gateway,
                    'payment_token' => $transactionId,
                    'model_type' => 'order',
                    'model_id' => $order->id,
                    'user_id' => auth()->id(),
                    'call_back_url' => env('APP_URL') . '/checkout/idpay',
                ]);
            }


            foreach (Cart::content() as $key => $item) {

                $detail = OrderDetail::create([
                    'product_id' => $key,
                    'product_data' => json_encode(['id' => $item->id, 'title' => $item->title]),
                    'price' => ($item->basePrice + FormBuilder::formPrice($item->form)) * $item->quantity,
                    'total_price' => $item->total(),
                    'status' => Order::STATUS_NOT_PAID,
                    'quantity' => $item->quantity,
                    'form' => json_encode($item->form),
                    'order_id' => $order->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                OrderNote::create([
                    'note' => 'سفارش '.$detail->tracking_code.' باموفقیت ثبت شد',
                    'is_user_note' => 1,
                    'is_read' => 0,
                    'order_id' => $detail->id,
                ]);
            }

            return $order->id ?? 0;
        });

        return $id;
    }
}
