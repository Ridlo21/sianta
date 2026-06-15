<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Profilecontroller extends Controller
{
    /**
     * Display the user profile view.
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Edit Profil';
        return view('users.profile', compact('title', 'user'));
    }

    /**
     * Update user profile information (Name, Email, Photo).
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sesi Anda telah berakhir.'
            ], 403);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        $messages = [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan oleh pengguna lain.',
            'photo.image' => 'Foto profil harus berupa file gambar.',
            'photo.mimes' => 'Foto profil harus berformat JPG, JPEG, atau PNG.',
            'photo.max' => 'Ukuran foto profil maksimal 2 MB.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $destinationPath = public_path('gambar_berkas/avatars');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $filename = 'avatar_user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

                // Delete old photo if it exists and is not default
                if ($user->photo && file_exists($destinationPath . '/' . $user->photo)) {
                    @unlink($destinationPath . '/' . $user->photo);
                }

                // Move file
                $file->move($destinationPath, $filename);
                $updateData['photo'] = $filename;
            }

            // Update user in DB
            User::where('id', $user->id)->update($updateData);

            return response()->json([
                'status' => 'success',
                'message' => 'Profil berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui profil: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sesi Anda telah berakhir.'
            ], 403);
        }

        $rules = [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ];

        $messages = [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password saat ini salah.'
            ], 422);
        }

        try {
            // Update password
            User::where('id', $user->id)->update([
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui password: ' . $e->getMessage()
            ], 500);
        }
    }
}
