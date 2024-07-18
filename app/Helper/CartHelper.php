<?php

namespace App\Helper;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;

class CartHelper
{
    public static function getCount(): int
    {
        if ($user = auth()->user()) {
            return CartItem::whereUserId($user->id)->count();
        } else {
            return array_reduce(self::getCookieCartItem(), fn ($carry) => $carry + 1, 0);
        }
    }

    public static function getCartItem()
    {
        if ($user = auth()->user()) {
            return CartItem::whereUserId($user->id)->get()->map(fn (CartItem $item) => ['product_id' => $item->product_id, 'quantity' => $item->quantity]);
        } else {
            return self::getCookieCartItem();
        }
    }

    public static function getCookieCartItem()
    {
        return json_decode(request()->cookie('cart', '[]'), true);
    }

    public static function setCookieCartItem(array $cartItem)
    {
        Cookie::queue('cart', json_encode($cartItem), 60 * 24 * 30);
    }

    public static function saveCookieCartItem()
    {
        $user = auth()->user();
        $userCartItem = CartItem::where('user_id', $user->id)->get()->keyBy('product_id');
        $saveCartItem = [];
        foreach (self::getCookieCartItem() as $item) {
            if (isset($userCartItem[$item['product_id']])) {
                $userCartItem[$item['product_id']]->update(['quantity' => $item['quantity']]);
                continue;
            } else {
                $saveCartItem[] = [
                    'user_id' => $user->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ];
            }
        }
        //insert data array from cookies to database model
        if (!empty($saveCartItem)) {
            CartItem::insert($saveCartItem);
        }
    }

    public static function moveCartItemIntoDB()
    {
        $request = request();
        $cartItem = self::getCookieCartItem();
        $newItemCart = [];
        foreach ($cartItem as $item) {
            $existingItemCart = CartItem::where([
                'user_id' => $request->user()->id,
                'product_id' => $item['product_id'],
            ])->first();
            if (!$existingItemCart) {
                $newItemCart[] = [
                    'user_id' => $request->user()->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity']
                ];
            }
        }

        if (!empty($newItemCart)) {
            //insert new item cart into database
            CartItem::insert($newItemCart);
        }
    }

    public static function getProductAndCartItem()
    {
        $cartItem = self::getCartItem();
        $id_product = Arr::pluck($cartItem, 'product_id');
        $products = Product::whereIn('id', $id_product)->with('product_images')->get();
        $cartItems = Arr::keyBy($cartItem, 'product_id');
        return [$products, $cartItems];
    }
}
