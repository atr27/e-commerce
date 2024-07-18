<?php

namespace App\Http\Controllers\User;

use App\Helper\CartHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function view(Request $request, Product $product)
    {
        $user = $request->user();
        if ($user) {
            $cartItem = CartItem::where('user_id', $user->id)->get();
            $userAddress = UserAddress::where('user_id', $user->id)->where('isMain', 1)->first();
            if ($cartItem->count() > 0) {
                return Inertia::render('User/Cart', [
                    'cartItem' => $cartItem,
                    'userAddress' => $userAddress
                ]);
            }
        } else {
            $cartItem = CartHelper::getCookieCartItem();
            if (count($cartItem) > 0) {
                $cartItem = new CartResource(CartHelper::getProductAndCartItem());
                return Inertia::render('User/Cart', [
                    'cartItem' => $cartItem,
                ]);
            } else {
                return redirect()->back();
            }
        }
    }

    public function store(Request $request, Product $product)
    {
        $quantity = $request->post('quantity', 1);
        $user = $request->user();
        if ($user) {
            $cart = CartItem::where('user_id', $user->id)->where('product_id', $product->id)->first();
            if ($cart) {
                $cart->increment('quantity');
            } else {
                $cart = new CartItem();
                $cart->user_id = $user->id;
                $cart->product_id = $product->id;
                $cart->quantity = 1;
                $cart->save();
            }
        } else {
            $cartItem = CartHelper::getCookieCartItem();
            $isProductExist = false;
            foreach ($cartItem as $item) {
                if ($item['product_id'] == $product->id) {
                    $item['quantity'] = $quantity;
                    $isProductExist = true;
                    break;
                }
            }

            if (!$isProductExist) {
                $cartItem[] = [
                    'user_id' => null,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price
                ];
            }
            CartHelper::setCookieCartItem($cartItem);
        }

        return redirect()->back()->with('success', 'add cart has successfully');
    }

    public function update(Request $request, Product $product)
    {
        $quantity = $request->integer('quantity');
        $user = $request->user();
        if ($user) {
            $cart = CartItem::where('user_id', $user->id)->where('product_id', $product->id)->first();
            if ($cart) {
                $cart->update(['quantity' => $quantity]);
            }
        } else {
            $cartItem = CartHelper::getCookieCartItem();
            foreach ($cartItem as &$item) {
                if ($item['product_id'] == $product->id) {
                    $item['quantity'] += $quantity;
                    break;
                }
            }
            CartHelper::setCookieCartItem($cartItem);
        }

        return redirect()->back();
    }

    public function delete(Request $request, Product $product)
    {
        $user = $request->user();
        if ($user) {
            CartItem::query()->where('user_id', $user->id)->where('product_id', $product->id)->first()?->delete();
            return redirect()->back();
        } else {
            $cartItem = CartHelper::getCookieCartItem();
            foreach ($cartItem as $key => &$item) {
                if ($item['product_id'] == $product->id) {
                    array_splice($cartItem, $key, 1);
                    break;
                }
            }
            CartHelper::setCookieCartItem($cartItem);
            return redirect()->back();
        }
    }
}
