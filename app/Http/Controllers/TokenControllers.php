<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException; 

class TokenControllers extends Controller
{
    public function buyOryToken(Request $request)
    {
        // 0. UJI KONEKSI DATABASE (Opsional, tapi aman jika ada keraguan koneksi)
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            Log::error("Koneksi DB Gagal Total di Awal Controller: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal terhubung ke database. Cek konfigurasi DB_HOST dan port.'
            ], 500);
        }

        // 1. VALIDASI INPUT DASAR
        try {
            $request->validate([
                'wallet_address' => 'required|string|max:255',
                // *************************************************************
                // PERBAIKAN: Mengganti 'transactions' menjadi 'transaction' 
                // *************************************************************
                'transaction_hash' => 'required|string|unique:transaction,transaction_address', 
                
                'orx_amount' => 'required|integer|min:1',
                'eth_paid' => 'required|string|max:255',
                'id_users' => 'required|integer', 
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi input gagal: Format data salah atau Hash Transaksi sudah tercatat.',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            // Ini akan menangkap jika tabel 'transaction' masih bermasalah
            Log::error("Query/Unique Check Gagal saat Validasi: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memverifikasi hash transaksi. (Database Error pada Unique Check)',
            ], 500);
        }
        
        $idUsers = (int)$request->input('id_users');
        $orxAmount = (int)$request->input('orx_amount');
        $transactionHash = $request->input('transaction_hash');
        $walletAddress = $request->input('wallet_address');
        $ethPaid = $request->input('eth_paid');
        
        // 2. VALIDASI KEBERADAAN USER (Manual dan Cepat)
        try {
            if (!DB::table('users')->where('id', $idUsers)->exists()) {
                Log::warning("Pembelian ORX Gagal: id_users ({$idUsers}) tidak ditemukan.");
                return response()->json([
                    'status' => 'error',
                    'message' => 'ID Pengguna tidak valid.',
                ], 404);
            }
        } catch (QueryException $e) {
            Log::error("Validasi User ID Gagal: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memverifikasi pengguna. (Database Error pada User Check)',
            ], 500);
        }

        // 3. PROSES TRANSAKSI DB
        $description = "Pembelian token ORX sejumlah {$orxAmount} pada wallet address: {$walletAddress}. Dibayar dengan ETH: {$ethPaid}.";
        
        DB::beginTransaction();

        try {
            // 3a. Catat Transaksi
            Transaction::create([
                'idUsers' => $idUsers,
                'jenis' => 'token',
                'descriptions' => $description,
                'transaction_address' => $transactionHash,
                'idBook' => null, 
            ]);

            // 3b. Dapatkan atau Buat Profile
            $profile = Profile::firstOrCreate(
                ['idUsers' => $idUsers],
                ['wallet_address' => $walletAddress, 'token' => 0] 
            );
            
            // 3c. Perbarui Saldo Token
            $currentTokens = $profile->token ?? 0;
            $profile->token = $currentTokens + $orxAmount;
            
            $profile->wallet_address = $walletAddress;
            $profile->save();
            
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Pembelian dan pencatatan token ORX berhasil di server.',
                'orx_amount' => $orxAmount,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error("Pembelian ORX Gagal dalam Transaksi DB (User {$idUsers}): " . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mencatat atau memperbarui saldo token di server (Kesalahan Database Transaksi).',
            ], 500);
        }
    }
}