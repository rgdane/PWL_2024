<?php

namespace App\Http\Controllers;

use App\Models\ProfileModel;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        // Membuat breadcrumb
        $breadcrumb = (object)[
            'title' => 'Profile User',
            'list' => ['Home', 'Profile']
        ];

        // Membuat objek halaman
        $page = (object)[
            'title' => 'Profile User'
        ];

        // Menentukan menu aktif
        $activeMenu = 'profile';

        // Mengambil ID user yang sedang login
        $id = auth()->id();

        // Mengambil data profile user yang login
        $profile = ProfileModel::where('user_id', $id)->first();
        if (!$profile) {
            ProfileModel::create([
                'user_id' => $id,
                'profile_email' => '',
                'profile_telepon' => '',
                'profile_alamat' => '',
                'profile_foto_url' => 'storage/img/default-profile.jpg',
            ]);

            $profile = ProfileModel::where('user_id', $id)->first();
        }
        // Ambil user yang sedang login
        $user = auth()->user();

        // Mengirim data ke view
        return view('profile.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'profile' => $profile, // Mengirim data profile user yang login
            'user' => $user // Mengirim data user yang login
        ]);
    }

    public function updateProfile(Request $request, string $id){
        $profile = ProfileModel::findOrFail($id);
        $request->validate([
            'profile_email' => 'required|string',
            'profile_telepon' => 'required|string|max:15',
            'profile_alamat' => 'required|string',
            'profile_foto_url' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Cek apakah ada file yang di-upload
        if ($request->hasFile('profile_foto_url')) {
            // Simpan file ke folder /public/img dan ambil path-nya
            $file = $request->file('profile_foto_url');
            $path = $file->storeAs('img', time().'.'.$file->getClientOriginalExtension(), 'public');
            
            // Simpan path ke database
            $profile->profile_foto_url = 'storage/' . $path; // Gunakan storage/ agar bisa diakses
        }

        $profile->profile_alamat = $request->profile_alamat;
        $profile->profile_email = $request->profile_email;
        $profile->profile_telepon = $request->profile_telepon;

        $profile->save();
        return redirect('/profile')->with('success' . "profile user berhasil diperbarui");
    }
}
