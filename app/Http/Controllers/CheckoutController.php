<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $cart = session()->get('cart', []);
        $total = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        $pesanan = Pesanan::create([
            'user_id' => $user->id,
            'username' => $user->name,
            'items' => $cart,
            'total' => $total,
        ]);

        // Kosongkan keranjang setelah checkout
        session()->forget('cart');

        return redirect()->route('index')->with('success', 'Pesanan Anda berhasil dibuat!');
    }
    public function acceptOrder($orderId)
    {
        $order = Pesanan::find($orderId);

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Pesanan tidak ditemukan.');
        }

        return view('orders.accept', compact('order'));
    }

    public function process(Request $request, $orderId)
    {
        // Retrieve the order by its ID
        $order = Pesanan::findOrFail($orderId);

        // Validate request data (example: validate student name and amount given)
        $request->validate([
            'student_name' => 'required|string',
            'amount_given' => 'required|numeric|min:0',
        ]);

        // Update the order with student name, amount given, calculate change, and update status
        $order->update([
            'student_name' => $request->student_name,
            'amount_given' => $request->amount_given,
            'change' => $request->amount_given - $order->total, // Calculate change
            'status' => 'completed', // Update order status
        ]);

        // Redirect to receipt page or wherever needed
        return redirect()->route('orders.receipt', ['order' => $order->id]);
    }
}