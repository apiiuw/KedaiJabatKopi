<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $title = 'Cart';

        // Pastikan session user tersedia
        if (!session()->has('id_user')) {
            session()->put('id_user', Str::uuid()->toString());
        }

        $idUser = session('id_user');

        // Ambil data cart beserta relasi ke menu
        $carts = Cart::with('menu')->where('id_user', $idUser)->get();

        // Total harga semua item
        $totalPrice = $carts->sum(function ($item) {
            return $item->menu->price * $item->quantity;
        });

        return view('customer.pages.cart.index', compact('title', 'carts', 'totalPrice'));
    }

    public function updateQty(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::findOrFail($id);

        if ($cart->id_user !== session('id_user')) {
            abort(403, 'Unauthorized action.');
        }

        $menuPrice = $cart->menu->price; // Ambil harga asli dari relasi menu

        $cart->update([
            'quantity' => $request->quantity,
            'price' => $menuPrice * $request->quantity, // Update harga total
        ]);

        return redirect()->route('customer.cart')->with('success', 'Quantity updated!');
    }

    public function edit($id)
    {
        $cart = Cart::with('menu')->findOrFail($id);

        // Pastikan data cart sesuai user session
        if ($cart->id_user !== session('id_user')) {
            abort(403, 'Unauthorized access.');
        }

        $menu = $cart->menu;

        return view('customer.pages.cart.edit', compact('menu', 'cart'));
    }

    public function updateForm(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        // Ambil input
        $quantity = (int) $request->input('quantity');
        $idMenu = $request->input('id_menu');

        // Dapatkan detail menu
        $menu = Menu::where('id_menu', $idMenu)->firstOrFail();

        // Buat deskripsi baru
        $descriptionParts = [];

        if ($request->has('iced_hot')) {
            $descriptionParts[] = ucfirst($request->input('iced_hot')); // Iced / Hot
        }

        if ($request->has('sweetness')) {
            $descriptionParts[] = $request->input('sweetness'); // Normal Sugar / Less Sugar
        }

        if ($request->has('espresso')) {
            $descriptionParts[] = $request->input('espresso'); // Single Shot / Double Shot
        }

        if ($request->filled('notes')) {
            $descriptionParts[] = trim($request->input('notes')); // Test request
        }

        $description = implode(', ', $descriptionParts);

        // Hitung harga baru
        $totalPrice = $menu->price * $quantity;

        // Simpan ke cart
        $cart->update([
            'id_menu' => $idMenu,
            'quantity' => $quantity,
            'description' => $description,
            'price' => $totalPrice,
        ]);

        return redirect()->route('customer.cart')->with('success', 'Cart updated successfully.');
    }

    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);

        // Cek apakah item milik user yang sedang aktif (berdasarkan session)
        if ($cart->id_user !== session('id_user')) {
            abort(403, 'Unauthorized action.');
        }

        $cart->delete();

        return redirect()->route('customer.cart')->with('success', 'Item removed from cart!');
    }
}
