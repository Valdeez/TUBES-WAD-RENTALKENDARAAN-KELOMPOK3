<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
class UserController extends Controller
{
    /**
     * READ – Tampilkan profil user login
     */
    public function show()
    {
        $user = User::findOrFail(Auth::id());


        return view('userProfile.profile', compact('user'));
    }

    /**
     * UPDATE – Update profil user login
     */
    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:255',
            'no_hp'  => 'nullable|string',
            'alamat' => 'nullable|string',
            'password' => 'required|min:8',
            

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name'   => $request->name,
            'no_hp'  => $request->no_hp,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * DELETE – Hapus akun user login
     */
    public function destroy(Request $request)
    {
        $user = User::findOrFail(Auth::id());


        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect('/register')->with('success', 'Akun berhasil dihapus');
    }
}
