<?php

namespace App\Http\Controllers\User;

use App\Helper\CartHelper;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Payment;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();
        $cartItem = $request->cartItem;
        $products = $request->products;

        $mergeData = [];
        foreach ($cartItem as $cart) {
            foreach ($products as $product) {
                if ($cart['product_id'] == $product['id']) {
                    $mergeData[] = array_merge($cart, [
                        'title' => $product['title'],
                        'price' => $product['price'],
                    ]);
                }
            }
        }

        // stripe payment
        $stripe = new \Stripe\StripeClient([
            'api_key' => 'sk_test_51PUfje00qMuu1X1opQSwAWT1P0NA50ZFPmVrQJlep1yP1IEp74Gh96lnN5SxDvOIzKCBhgMJWz2lTAYeAJ13OBfF00nH0BtwaK',
        ]);
        $lineItems = [];
        foreach ($mergeData as $data) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $data['title'],
                    ],
                    'unit_amount' => (int) ($data['price'] * 100),
                ],
                'quantity' => $data['quantity'],
            ];
        }

        $checkoutSession = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.canceled'),
        ]);

        $newAddress = $request->address;
        if ($newAddress['address1'] != null) {
            $address = UserAddress::where('isMain', 1)->count();
            if ($address > 0) {
                $address = UserAddress::where('isMain', 1)->update([
                    'isMain' => 0
                ]);
            }
            $address = new UserAddress();
            $address->address1 = $newAddress['address1'];
            $address->city = $newAddress['city'];
            $address->state = $newAddress['state'];
            $address->zipcode = $newAddress['zipCode'];
            $address->country_code = $newAddress['countryCode'];
            $address->type = $newAddress['addressType'];
            $address->user_id = Auth::user()->id;
            $address->save();
        }

        $mainAddress = $user->user_address()->where('isMain', 1)->first();
        if ($mainAddress) {
            $order = new Order();
            $order->status = 'unpaid';
            $order->total_price = $request->total;
            $order->session_id = $checkoutSession->id;
            $order->created_by = $user->id;
            //if main address exist and isMain = 1
            $order->user_address_id = $mainAddress->id;
            $order->save();

            $cartItems = CartItem::where(['user_id' => $user->id])->get();
            foreach ($cartItems as $cartItem) {
                $order_item = new OrderItems();
                $order_item->order_id = $order->id;
                $order_item->product_id = $cartItem->product_id;
                $order_item->quantity = $cartItem->quantity;
                $order_item->unit_price = $cartItem->product->price;
                $order_item->save();

                $cartItem->delete();
                //remove cart items from cookies
                $cartItems = CartHelper::getCookieCartItem();
                foreach ($cartItems as $item) {
                    unset($item);
                }
                array_splice($cartItems, 0, count($cartItems));
                CartHelper::setCookieCartItem($cartItems);
            }

            $payment = new Payment();
            $payment->order_id = $order->id;
            $payment->amount = $request->total;
            $payment->status = 'pending';
            $payment->type = 'stripe';
            $payment->created_by = $user->id;
            $payment->updated_by = $user->id;
            $payment->save();
        }

        return Inertia::location($checkoutSession->url);
    }

    public function success(Request $request)
    {
        \Stripe\Stripe::setApiKey('sk_test_51PUfje00qMuu1X1opQSwAWT1P0NA50ZFPmVrQJlep1yP1IEp74Gh96lnN5SxDvOIzKCBhgMJWz2lTAYeAJ13OBfF00nH0BtwaK');
        $sessionId = $request->get('session_id');
        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            if(!$session){
                throw new NotFoundHttpException;
            }else{
                $order = Order::where('session_id', $session->id)->first();
                if(!$order){
                    throw new NotFoundHttpException;
                }
                if($order->status == 'unpaid'){
                    $order->status = 'paid';
                    $order->save();
                }

                return redirect()->route('dashboard');

            }
        } catch (\Exception $e) {
            throw new NotFoundHttpException;
        }
    }
}
