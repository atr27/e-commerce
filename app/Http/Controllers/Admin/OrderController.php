<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('order_items.product.brand', 'order_items.product.category', 'order_items.product.product_images', 'user_address')->get();
        return Inertia::render('Admin/Orders/Index', ['orders' => $orders]);
    }
}
