<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccessControlController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Owner Access Control';
        $query = User::query();

        // Flag dan data untuk notifikasi
        $isFiltered = false;
        $isSorted = false;
        $filteredCount = 0;
        $sortedBy = '';
        $sortedDirLabel = '';

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
            });
            $isFiltered = true;
        }

        // Filter Role
        if ($request->filled('s_role')) {
            $query->where('role', $request->s_role);
            $isFiltered = true;
        }

        // Sorting
        if ($request->sort === 'date') {
            $direction = $request->dir === 'desc' ? 'desc' : 'asc';
            $query->orderBy('created_at', $direction);
            $isSorted = true;
            $sortedBy = 'Join Date';
            $sortedDirLabel = $direction === 'asc' ? 'Oldest to Newest' : 'Newest to Oldest';
        } else {
            // Default sorting
            $query->orderByRaw("
                CASE 
                    WHEN role = 'Owner' THEN 1
                    WHEN role = 'Cashier' THEN 2
                    ELSE 3
                END
            ")->orderBy('created_at', 'asc');
        }

        $users = $query->get();

        // Hitung jumlah data setelah filter
        $filteredCount = $users->count();

        // Count total per role
        $totalCashier = User::where('role', 'Cashier')->count();
        $totalOwner   = User::where('role', 'Owner')->count();
        $totalAll     = User::count();

        return view('owner.pages.access-control.index', compact(
            'title',
            'users',
            'totalCashier',
            'totalOwner',
            'totalAll',
            'isFiltered',
            'isSorted',
            'filteredCount',
            'sortedBy',
            'sortedDirLabel'
        ));
    }

    public function addAccount()
    {
        $title = 'Owner Add Account';

         return view('owner.pages.access-control.create', compact(
            'title',
        ));
    }

    public function storeAccount(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'role'              => 'required|string',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|min:6|confirmed',
        ], [
            'name.required'         => 'Full Name is required.',
            'name.string'           => 'Full Name must be a valid text.',
            'name.max'              => 'Full Name cannot exceed 255 characters.',

            'role.required'         => 'Role is required.',
            'role.string'           => 'Role must be a valid string.',

            'email.required'        => 'Email is required.',
            'email.email'           => 'Please enter a valid email address.',
            'email.unique'          => 'This email is already registered. Please use another one.',

            'password.required'     => 'Password is required.',
            'password.min'          => 'Password must be at least 6 characters.',
            'password.confirmed'    => 'Password confirmation does not match.',
        ]);

        // Generate unique ID user
        $prefix = strtoupper($request->role); // CASHIER / OWNER
        do {
            $randomNumber = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $id_user = $prefix . $randomNumber;
        } while (User::where('id_user', $id_user)->exists());

        // Simpan ke database
        User::create([
            'id_user'  => $id_user,
            'name'     => $request->name,
            'role'     => $request->role,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('owner.access-control')
                        ->with('success', 'Account has been created successfully!');
    }

    public function edit($id)
    {
        $title = 'Owner Edit Account';
        $user = User::findOrFail($id);

        // Kirim data ke view
        return view('owner.pages.access-control.edit', compact('user', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('owner.access-control')->with('success', 'User data has been updated successfully.');
    }

}
