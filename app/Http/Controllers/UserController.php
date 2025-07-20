<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        $users->map(function ($user) {
            $user->role_name = $user->roles->pluck('name')->implode(', ');
            return $user;
        });
        return view('backend.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all(); // Ambil semua field termasuk name
        return view('backend.users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/backend/img'), $imageName);
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'image' => $imageName,
        ];

        $user = User::create($userData);
        $user->assignRole($request->input('roles'));

        return redirect()->route('user')->with('message', 'User berhasil disimpan!');
    }

    public function edit($id)
    {
        $edituser = User::findOrFail($id);
        $roles = Role::pluck('name', 'id');
        $userRole = $edituser->roles->pluck('id')->toArray();

        return view('backend.users.edit', compact('edituser', 'roles', 'userRole'));
    }

    public function update(UsersUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            $oldImageName = $user->image;

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/backend/img'), $imageName);

            if ($oldImageName !== null) {
                $oldImagePath = public_path('assets/backend/img') . '/' . $oldImageName;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $data['image'] = $imageName;
        }

        if (!empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        } else {
            $user->roles()->detach();
        }

        return redirect()->route('user')->with('message', 'User berhasil diperbarui!');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        // Hapus gambar jika ada
        if ($user->image) {
            $imagePath = public_path('assets/backend/img') . '/' . $user->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $user->roles()->detach();
        $user->delete();

        return redirect()->route('user')->with('message', 'Users berhasil dihapus!');
    }
}
