<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function contacts()
    {
        return view('admin.contacts');
    }

    public function orders()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function updatePaymentStatus($id)
    {
        $order = Order::findOrFail($id);
        $order->payment_status = 'paid';
        $order->save();

        return back()->with('success', 'Payment status updated!');
    }
}
