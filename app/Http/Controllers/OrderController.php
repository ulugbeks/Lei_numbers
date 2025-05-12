<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Stripe\StripeClient;

class OrderController extends Controller
{
    public function submit(Request $request)
    {
        try {
            // Валидация данных
            $validated = $request->validate([
                'full_name' => 'required|string',
                'company_name' => 'nullable|string',
                'registration_id' => 'required|string',
                'country' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
                'plan' => 'required|string',
            ]);

            // Сохранение заявки в базу
            $order = Order::create([
                'full_name' => $validated['full_name'],
                'company_name' => $validated['company_name'] ?? '',
                'registration_id' => $validated['registration_id'],
                'country' => $validated['country'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'plan' => $validated['plan'],
                'total_price' => $this->calculatePrice($validated['plan']),
                'payment_status' => 'pending',
            ]);

            // === создаём PaymentIntent ===
            $stripe = new StripeClient(config('services.stripe.secret'));
            $intent = $stripe->paymentIntents->create([
                'amount'   => $order->total_price * 100,     // в центах
                'currency' => 'usd',
                'metadata' => ['order_id' => $order->id],
            ]);

            // === возвращаем ID и client_secret ===
            return response()->json([
                'success'      => true,
                'order_id'     => $order->id,
                'clientSecret' => $intent->client_secret,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    private function calculatePrice($plan)
    {
        $prices = [
            '1-year' => 75,
            '3-years' => 165,
            '5-years' => 250,
        ];
        return $prices[$plan] ?? 75;
    }

    public function show(Request $request)
    {
        $order_id = $request->query('order');
        $order = Order::find($order_id);

        if (!$order) {
            abort(404);
        }

        return view('order.payment', compact('order'));
    }

    public function updatePaymentStatus(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->payment_status = 'paid';
        $order->save();

        return response()->json(['success' => true]);
    }
}
