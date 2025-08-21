<?php

namespace App\Http\Controllers\Midtrans;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\PaymentReceiptMail;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function checkout(Request $request)
    {
        $idUser = session('id_user');

        $carts = Cart::with('menu')->where('id_user', $idUser)->get();
        $total = $carts->sum('price');
        $order_id = 'ORDER-' . time();

        // Mendapatkan jenis pesanan (Dine In atau Takeaway)
        $orderType = $request->input('order_type');
        $tableNumber = ($orderType == 'Dine In') ? $request->input('table_number') : null;

        session([
            'id_user' => $idUser,
            'customer_name' => $request->name,
            'customer_email' => $request->email,
            'customer_order_type' => $orderType,
            'customer_table_number' => $tableNumber,
            'latest_order_id' => $order_id,
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => $request->name,
                'email' => $request->email,
            ],
            'enabled_payments' => [
                'gopay', 'bca_va', 'shopeepay', 'qris',
            ],
            'callbacks' => [
                'finish' => route('customer.payment.success'),
            ],
            'item_details' => $carts->map(function ($cart) {
                return [
                    'id' => $cart->id,
                    'price' => $cart->menu->price,
                    'quantity' => $cart->quantity,
                    'name' => $cart->menu->product_name,
                ];
            })->toArray()
        ];

        $snapToken = Snap::getSnapToken($params);
        return response()->json(['snap_token' => $snapToken]);
    }

    public function paymentSuccess(Request $request)
    {
        $idUser = session('id_user');
        $orderId = session('latest_order_id');
        $name = session('customer_name');
        $email = session('customer_email');
        $tableNumber = session('customer_table_number');
        $orderType = session('customer_order_type'); // Mendapatkan order_type dari session

        if (!$idUser || !$orderId) {
            return redirect()->route('customer.home')->with([
                'status' => 'error',
                'message' => 'Order session tidak ditemukan. Silakan coba lagi.',
            ]);
        }

        // Mengecek apakah order sudah diproses sebelumnya
        if (Order::where('id_order', $orderId)->exists()) {
            return redirect()->route('customer.home')->with([
                'status' => 'success',
                'message' => 'Order sudah diproses.',
            ]);
        }

        $carts = Cart::with('menu')->where('id_user', $idUser)->get();

        if ($carts->isEmpty()) {
            return redirect()->route('customer.home')->with([
                'status' => 'error',
                'message' => 'Keranjang kosong atau sudah diproses.',
            ]);
        }

        foreach ($carts as $cart) {
            OrderItem::create([
                'id_order' => $orderId,
                'id_menu' => $cart->id_menu,
                'category' => $cart->menu->category,
                'type' => $cart->menu->type,
                'quantity' => $cart->quantity,
                'price' => $cart->menu->price * $cart->quantity,
                'description' => $cart->description,
            ]);
        }

        $total = $carts->sum(function ($cart) {
            return $cart->menu->price * $cart->quantity;
        });

        // Menghitung nomor antrian hari ini
        $today = now()->toDateString();
        $lastQueue = Order::whereDate('created_at', $today)->max('queue_number');
        $queueNumber = $lastQueue ? $lastQueue + 1 : 1;

        // Menyimpan order dan order_type
        $order = Order::create([
            'id_order'      => $orderId,
            'id_user'       => $idUser,
            'name'          => $name,
            'email'         => $email,
            'table_number'  => $tableNumber, // Akan null jika Takeaway
            'order_type'    => $orderType, // Menyimpan tipe pesanan
            'total_amount'  => $total,
            'status'        => 'paid',
            'queue_number'  => $queueNumber, // Menyimpan nomor antrian
        ]);

        // Mengirim email struk
        Mail::to($email)->send(new PaymentReceiptMail($order->load('items.menu')));

        // Membersihkan keranjang dan session
        Cart::where('id_user', $idUser)->delete();
        session()->forget([
            'customer_name',
            'customer_email',
            'customer_order_type',
            'customer_table_number',
            'latest_order_id',
        ]);

        return redirect()->route('customer.home')->with([
            'status' => 'success',
            'message' => 'Pembayaran berhasil! Pesanan Anda sedang diproses.',
            'queue_number' => $queueNumber,
        ]);
    }

}
