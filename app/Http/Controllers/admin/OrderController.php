<?php

namespace App\Http\Controllers\admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Mostra la risorsa 'ordine'.
     */
    public function show(Order $order)
    {
        $order = Order::where('id', '=', $order->id)->with('dishes')->get();
        return response()->json($order);
    }


    /* L'ordine è stato evaso correttamente. */
    public function shipped($order_id){
        $order = Order::all()->where('id', '=', $order_id)->first();
        $order->shipped = 1;
        $order->save();
        return view('restaurant.orders');
    }
}
