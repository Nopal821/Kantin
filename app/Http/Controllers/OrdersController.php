<?php
namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    // Index method to list all orders
    public function index()
    {
        $orders = Pesanan::latest()->paginate(10); // Example: Get orders, latest first, paginated

        return view('orders.index', compact('orders'));
    }

    // Accept method to mark an order as accepted
    public function accept($orderId)
    {
        $order = Pesanan::findOrFail($orderId);
        $order->status = 'accepted';
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order accepted successfully.');
    }

    // Process method to process the order
    public function process(Request $request, $orderId)
    {
        $order = Pesanan::findOrFail($orderId);

        // Update order with additional details
        $order->student_name = $request->input('student_name');
        $order->amount_given = $request->input('amount_given');
        $order->change = $order->amount_given - $order->total;
        $order->status = 'processed';
        $order->save();

        return redirect()->route('orders.receipt', $order->id)->with('success', 'Order processed successfully.');
    }

    // Receipt method to generate a receipt for the order
    public function receipt(Pesanan $order)
    {
        return view('orders.receipt', compact('order'));
    }

    // Complete method to mark an order as completed
    public function complete(Pesanan $order)
    {
        $order->status = 'completed';
        $order->save();
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order completed successfully.');
    }
}
