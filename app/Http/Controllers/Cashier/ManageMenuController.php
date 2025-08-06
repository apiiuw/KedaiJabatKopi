<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Intervention\Image\Facades\Image;

class ManageMenuController extends Controller
{
    public function index()
    {
        $title = 'Cashier Manage Menu';
        $menus = Menu::all(); // Semua menu

        // Hitung total berdasarkan category
        $totalDrinks = Menu::where('category', 'Drink')->count();
        $totalFoods = Menu::where('category', 'Food')->count();
        $totalMenus = $menus->count();

        return view('cashier.pages.manage-menu.index', compact('title', 'menus', 'totalDrinks', 'totalFoods', 'totalMenus'));
    }

    public function addMenu()
    {
        $title = 'Cashier Add Menu';

        return view('cashier.pages.manage-menu.create', compact('title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'type' => 'nullable|string',
            'custom_type' => 'nullable|string',
            'availability' => 'required|string',
            'price' => 'required|numeric',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Generate id_menu format MENUxxxx (angka unik)
        do {
            $number = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (Menu::where('id_menu', 'MENU' . $number)->exists());

        $idMenu = 'MENU' . $number;

        // Ambil custom type jika Other
        $validated['type'] = $validated['type'] === 'Other' && $request->custom_type
            ? $request->custom_type
            : $validated['type'];

        // Checkbox Sweetness & Espresso
        $validated['sweetness'] = $request->has('sweetness') ? 1 : 0;
        $validated['espresso'] = $request->has('espresso') ? 1 : 0;

        // Upload + Crop Square Center
        if ($request->hasFile('picture')) {
            $imageFile = $request->file('picture');
            $filename = time() . '_' . $idMenu . '.' . $imageFile->getClientOriginalExtension();

            $image = Image::make($imageFile->getRealPath());

            // Ambil ukuran terkecil
            $size = min($image->width(), $image->height());

            // Crop di tengah
            $image->crop(
                $size,
                $size,
                intval(($image->width() - $size) / 2),
                intval(($image->height() - $size) / 2)
            );

            // Resize ke ukuran 500x500 px
            $image->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Simpan langsung ke public/data/menus-image
            $destinationPath = public_path('data/menus-image');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $image->save($destinationPath . '/' . $filename);

            // Simpan path relatif di database
            $validated['picture'] = 'data/menus-image/' . $filename;
        }

        // Simpan id_menu
        $validated['id_menu'] = $idMenu;

        // Simpan ke database (termasuk description)
        Menu::create($validated);

        return redirect()->route('cashier.manage-menu')
            ->with('success', 'Menu added successfully!');
    }


    public function editMenu($id_menu)
    {
        $title = 'Cashier Edit Menu';
        $menu = Menu::where('id_menu', $id_menu)->firstOrFail(); // Ambil data menu

        return view('cashier.pages.manage-menu.edit', compact('title', 'menu'));
    }

    public function update(Request $request, $id_menu)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'type' => 'nullable|string',
            'custom_type' => 'nullable|string',
            'availability' => 'required|string',
            'price' => 'required|numeric',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ambil data menu lama
        $menu = Menu::where('id_menu', $id_menu)->firstOrFail();

        // Jika type = Other ambil custom_type
        $validated['type'] = $validated['type'] === 'Other' && $request->custom_type
            ? $request->custom_type
            : $validated['type'];

        // Checkbox
        $validated['sweetness'] = $request->has('sweetness') ? 1 : 0;
        $validated['espresso'] = $request->has('espresso') ? 1 : 0;

        // Upload foto baru (jika ada)
        if ($request->hasFile('picture')) {
            $imageFile = $request->file('picture');
            $filename = time() . '_' . $menu->id_menu . '.' . $imageFile->getClientOriginalExtension();

            $image = Image::make($imageFile->getRealPath());

            $size = min($image->width(), $image->height());
            $image->crop(
                $size,
                $size,
                intval(($image->width() - $size) / 2),
                intval(($image->height() - $size) / 2)
            );

            $image->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $destinationPath = public_path('data/menus-image');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $image->save($destinationPath . '/' . $filename);

            $validated['picture'] = 'data/menus-image/' . $filename;
        }

        // Update data
        $menu->update($validated);

        return redirect()->route('cashier.manage-menu')->with('success', 'Menu updated successfully!');
    }

}
