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

        return view('cashier.pages.manage-menu.index', compact('title'));
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
            'category' => 'required|string',
            'type' => 'nullable|string',
            'custom_type' => 'nullable|string',
            'availability' => 'required|string',
            'price' => 'required|numeric',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Generate kode random
        $idMenu = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));

        // Ambil custom type jika Other
        $validated['type'] = $validated['type'] === 'Other' && $request->custom_type
            ? $request->custom_type
            : $validated['type'];

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
                $constraint->aspectRatio(); // Jaga rasio
                $constraint->upsize(); // Hindari pembesaran berlebihan
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


        $validated['id_menu'] = $idMenu;

        Menu::create($validated);

        return redirect()->route('cashier.manage-menu')->with('success', 'Menu added successfully!');
    }

}
