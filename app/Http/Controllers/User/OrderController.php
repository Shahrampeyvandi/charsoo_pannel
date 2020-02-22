<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders\Order;

class OrderController extends Controller
{
    public function OrderList()
    {
        $orders = Order::latest()->get();
        return view('User.Orders.OrderList',compact('orders'));
    }
}
