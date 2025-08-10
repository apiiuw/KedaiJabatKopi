<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Intervention\Image\Facades\Image;

class ManageMenuController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Cashier Manage Menu';

        // Query dasar
        $menusQuery = Menu::query();

        // Search
        if ($q = $request->input('q')) {
            $q = trim($q);
            $menusQuery->where(function ($s) use ($q) {
                $s->where('product_name', 'like', "%{$q}%")
                ->orWhere('type', 'like', "%{$q}%")
                ->orWhere('id_menu', 'like', "%{$q}%");
            });
        }

        // Filter kategori
        if ($category = $request->input('category')) {
            if (in_array($category, ['Food','Drink'])) {
                $menusQuery->where('category', $category);
            }
        }

        // Filter availability
        if ($availability = $request->input('availability')) {
            if (in_array($availability, ['available','not available'])) {
                $menusQuery->where('availability', $availability);
            }
        }

        // SORT (by price)
        $sort = $request->input('sort');           // 'price' | null
        $dir  = $request->input('dir', 'asc');     // 'asc' | 'desc'
        $dir  = in_array($dir, ['asc','desc']) ? $dir : 'asc';

        if ($sort === 'price') {
            $menusQuery->orderBy('price', $dir);
        } else {
            $menusQuery->orderBy('product_name', 'asc'); // default
        }

        $menus = $menusQuery->get();

        // Statistik (tidak terpengaruh filter/search)
        $totalDrinks = Menu::where('category', 'Drink')->count();
        $totalFoods  = Menu::where('category', 'Food')->count();
        $totalMenus  = Menu::count();

        // Flags notifikasi
        $isFiltered    = $request->filled('q') || $request->filled('category') || $request->filled('availability');
        $filteredCount = $menus->count();

        $isSorted       = ($sort === 'price');
        $sortedBy       = $isSorted ? 'Price' : '';
        $sortedDirLabel = $dir === 'asc' ? 'Ascending' : 'Descending';

        return view('cashier.pages.manage-menu.index', compact(
            'title','menus','totalDrinks','totalFoods','totalMenus',
            'isFiltered','filteredCount','isSorted','sortedBy','sortedDirLabel',
            'sort','dir'
        ));
    }

    public function addMenu()
    {
        $title = 'Cashier Add Menu';

        return view('cashier.pages.manage-menu.create', compact('title'));
    }

    public function store(Request $request)
    {
        $messages = [
            // product_name
            'product_name.required' => 'Product name is required.',
            'product_name.string'   => 'Product name must be text.',
            'product_name.max'      => 'Product name may not be greater than :max characters.',

            // description
            'description.required'  => 'Description is required.',
            'description.string'    => 'Description must be text.',

            // category
            'category.required'     => 'Category is required.',
            'category.string'       => 'Category must be text.',

            // type
            'type.required'         => 'Type is required.',
            'type.string'           => 'Type must be text.',

            // custom_type (when type = Other)
            'custom_type.required_if' => 'Please fill Custom Type when Type is "Other".',
            'custom_type.string'      => 'Custom Type must be text.',

            // availability
            'availability.required' => 'Availability is required.',
            'availability.string'   => 'Availability must be text.',

            // price
            'price.required'        => 'Price is required.',
            'price.numeric'         => 'Price must be a number.',

            // picture
            'picture.required'      => 'Picture is required.',
            'picture.image'         => 'Picture must be an image file.',
            'picture.mimes'         => 'Picture must be a file of type: jpg, jpeg, png.',
            'picture.max'           => 'Picture size must not exceed 2MB.',
        ];

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description'  => 'required|string',
            'category'     => 'required|string',
            'type'         => 'required|string',
            'custom_type'  => 'required_if:type,Other|nullable|string',
            'availability' => 'required|string',
            'price'        => 'required|numeric',
            'picture'      => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], $messages);

        // Generate id_menu format MENUxxxx (angka unik)
        do {
            $number = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (Menu::where('id_menu', 'MENU' . $number)->exists());

        $idMenu = 'MENU' . $number;

        // Ambil custom type jika Other
        $validated['type'] = $validated['type'] === 'Other' && $request->custom_type
            ? $request->custom_type
            : $validated['type'];

        // Checkbox Iced/Hot, Sweetness & Espresso
        $validated['iced_hot'] = $request->has('iced_hot') ? 1 : 0;
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
        $validated['iced_hot'] = $request->has('iced_hot') ? 1 : 0;
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
