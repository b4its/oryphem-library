<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User; // Pastikan ini adalah namespace Model User yang benar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MetamaskController extends Controller
{
    public function connectMetamask(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'wallet_address' => 'required|string',
            'signature' => 'required|string',
        ]);

        $walletAddress = $request->input('wallet_address');
        $signature = $request->input('signature');
        
        // Pesan yang sama persis dengan yang ada di JavaScript
        $message = 'Authorize connection to your Metamask wallet for this application.'; 

        // 2. VERIFIKASI TANDA TANGAN DI SINI! (Simulasi sukses)
        // PENTING: Anda HARUS mengimplementasikan logika verifikasi signature Ethereum yang sebenarnya
        $isVerified = true; 

        if (!$isVerified) {
            return response()->json([
                'message' => 'Signature verification failed. Wallet not connected.'
            ], 401);
        }

        // 3. Simpan Alamat Dompet ke User yang sedang Login
        
        /** @var \App\Models\User $user */ // Docblock untuk Intelephense
        $profile = Profile::where('idUsers', Auth::id())->first();
        
        if (!$profile) {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }

        $profile->wallet_address = $walletAddress;
        $profile->save(); 
        
        // 4. Sukses: Kembalikan respons yang akan dialihkan oleh JavaScript
        return response()->json([
            'message' => 'Wallet connected successfully.',
            'redirect' => route('dashboard') // Menggunakan 'dashboard' sesuai route list Anda
        ], 200);
    }
}