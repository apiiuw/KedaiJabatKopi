<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Menu;
use App\Models\Cart;

class DetailItemController extends Controller
{
    public function index(Request $request, $id_menu)
    {
        $menu = Menu::where('id_menu', $id_menu)->firstOrFail();
        $title = $menu->product_name;

        // Ambil kategori dari query string jika ada, atau dari menu ini
        $category = $request->get('category', $menu->category);

        return view('customer.pages.detail-item.index', compact('title', 'menu', 'category'));
    }

    public function addToCart(Request $request)
    {
        // Pastikan ada id_user di session
        if (!session()->has('id_user')) {
            session()->put('id_user', Str::uuid()->toString());
        }

        $idUser = session('id_user');

        // Ambil harga dari tabel Menu
        $menu = Menu::where('id_menu', $request->id_menu)->firstOrFail();
        $quantity = $request->quantity ?? 1;
        $totalPrice = $menu->price * $quantity;

        // Mapping label
        $icedHotLabel = [
            'iced' => 'Iced',
            'hot' => 'Hot'
        ];

        $sweetnessLabel = [
            'normal' => 'Normal Sugar',
            'less' => 'Less Sugar'
        ];

        $espressoLabel = [
            'single' => 'Single Shot',
            'double' => 'Double Shot'
        ];

        // Buat array deskripsi
        $descParts = [];

        if ($request->iced_hot && isset($icedHotLabel[$request->iced_hot])) {
            $descParts[] = $icedHotLabel[$request->iced_hot];
        }

        if ($request->sweetness && isset($sweetnessLabel[$request->sweetness])) {
            $descParts[] = $sweetnessLabel[$request->sweetness];
        }

        if ($request->espresso && isset($espressoLabel[$request->espresso])) {
            $descParts[] = $espressoLabel[$request->espresso];
        }

        if ($request->notes) {
            $descParts[] = $request->notes;
        }

        // Gabungkan jadi string
        $description = implode(', ', $descParts);

        // Simpan ke cart
        Cart::create([
            'id_user'     => $idUser,
            'id_menu'     => $request->id_menu,
            'description' => $description,
            'quantity'    => $quantity,
            'price'       => $totalPrice // harga total hasil perkalian
        ]);

        return redirect()->route('customer.menu')->with('success', 'Item added to cart!');
    }

}
