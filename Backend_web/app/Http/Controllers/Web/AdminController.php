<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::all();
        $currentAdmin = Auth::guard('admin')->user();

        return view('admin.index', compact('admins', 'currentAdmin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email'],
            'username' => ['required', 'string', 'max:255', 'unique:admins,username'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('admin.index')
            ->with('success', 'Admin baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = Admin::findOrFail($id);
        $currentAdmin = Auth::guard('admin')->user();

        if (!$currentAdmin || (string)$currentAdmin->getKey() !== (string)$admin->getKey()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit admin lain.');
        }

        return view('admin.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $admin = Admin::findOrFail($id);
        $currentAdmin = Auth::guard('admin')->user();

        if (!$currentAdmin || (string)$currentAdmin->getKey() !== (string)$admin->getKey()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit admin lain.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('admins', 'email')->ignore($admin->getKey(), $admin->getKeyName()),
            ],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('admins', 'username')->ignore($admin->getKey(), $admin->getKeyName()),
            ],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $admin->name = $data['name'];
        $admin->email = $data['email'];
        $admin->username = $data['username'];

        if (!empty($data['password'])) {
            $admin->password = Hash::make($data['password']);
        }

        $admin->save();

        return redirect()->route('admin.index')
            ->with('success', 'Profil admin berhasil diperbarui.');
    }
}
