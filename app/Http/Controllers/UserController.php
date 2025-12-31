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
     * READ – Menampilkan data user
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'message' => '',
            'data' => $user
        ], 200);
    }

    /**
     * UPDATE – Mengubah data user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'   => 'sometimes|required|string|max:255',
            'email'  => 'sometimes|required|email|unique:users,email,' . $id,
            'no_hp'  => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'error'   => $validator->errors()
            ], 422);
        }

        $user->update($request->only([
            'name',
            'email',
            'no_hp',
            'alamat'
        ]));

        return response()->json([
            'message' => 'Data anda berhasil diperbarui',
            'data' => $user
        ], 200);
    }

    /**
     * DELETE – Menghapus data user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'message' => 'Akun anda berhasil dihapus'
        ], 200);
    }
}
