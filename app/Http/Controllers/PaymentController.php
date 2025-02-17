<?php 

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Order;

class PaymentController extends Controller
{
    public function process(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $charge = Charge::create([
                "amount" => Order::find($request->order_id)->total_price * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "LEI Registration Payment"
            ]);

            // Обновляем заказ
            $order = Order::find($request->order_id);
            $order->status = 'paid';
            $order->save();

            return response()->json(["success" => true]);
        } catch (\Exception $e) {
            return response()->json(["success" => false, "message" => $e->getMessage()]);
        }
    }
}
