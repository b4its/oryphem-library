<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookOwner;
use App\Models\User; // Pastikan model User di-import
use App\Models\Profile; // Pastikan model Profile di-import
use App\Models\Transaction; // Pastikan model Transaction di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Untuk menggunakan Transaksi Database
use Illuminate\Validation\ValidationException;

class BookControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function api_getBook_all()
    {
        // Menggunakan with('category') untuk Eager Loading relasi
        // 'category' yang sudah Anda definisikan di model Book.
        // Ini akan mengambil data buku BESERTA data kategori terkait.
        $books = Book::with('category')->get(); 

        // Sekarang, $books akan menyertakan properti 'category'
        // yang merupakan objek Category, dan Laravel akan mengkonversinya ke JSON.
        return response()->json($books);
    }

    public function index()
    {
        //
        $books = Book::orderBy('created_at', 'desc')->limit(5)->get(); 

        // 2. Laravel akan mengkonversi koleksi Eloquent ini secara otomatis
        //    menjadi JSON, yang mencakup semua kolom (termasuk id, created_at, updated_at).
        //    'content' (yang menyimpan tech sebagai string) dan 'idCategory' serta 'price'
        //    akan ikut terkirim.
        
        return view('welcome', 
        [
            'books' => $books
        ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function purchaseBook(Request $request)
    {
        // 1. Validasi Input
        try {
            $request->validate([
                'book_id' => 'required|integer|exists:book,id',
                'wallet_address' => 'required|string|regex:/^0x[a-fA-F0-9]{40}$/',
                'transaction_hash' => 'required|string|unique:transaction,transaction_address',
                'price_paid' => 'required|numeric|min:0',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data input tidak valid: ' . $e->getMessage()
            ], 400);
        }

        // Wallet Penerima (Platform Owner)
        $platformWalletAddress = '0x6EdcA860c066FCdA6c434095d5901810DCE12b48';

        try {
            DB::beginTransaction();

            // 2. Cari Data
            $book = Book::find($request->book_id);
            // Cari pengguna berdasarkan wallet_address (di tabel Profile)
            $profile = Profile::where('wallet_address', $request->wallet_address)->first();

            if (!$book) {
                throw new \Exception("Buku tidak ditemukan.");
            }
            if (!$profile) {
                // Asumsi: Pengguna harus sudah terdaftar dengan wallet address-nya
                throw new \Exception("Alamat dompet tidak terdaftar.");
            }

            // 3. Verifikasi Harga
            if ($book->price != $request->price_paid) {
                // PENTING: Untuk lingkungan produksi, verifikasi harga dan transfer 
                // harus dilakukan secara ketat di sisi server melalui API Blockchain.
                throw new \Exception("Harga yang dibayarkan tidak sesuai dengan harga buku.");
            }

            // 4. Catat Transaksi
            $transaction = Transaction::create([
                'idUsers' => $profile->idUsers, // ID User yang membeli
                'idBook' => $book->id,
                'jenis' => 'buku',
                'descriptions' => "Pembelian buku '{$book->name}' seharga {$request->price_paid} ORX ke {$platformWalletAddress}.",
                'transaction_address' => $request->transaction_hash,
            ]);

            // 5. Catat Kepemilikan Buku (book_owner) 🚀
            $bookOwner = BookOwner::create([
                'idUsers' => $profile->idUsers,
                'idTransaction' => $transaction->id,
            ]);

            // 6. Perbarui Status Buku (Opsional: tingkatkan hitungan sold)
            $book->increment('sold');

            DB::commit(); // Konfirmasi semua perubahan

            return response()->json([
                'status' => 'success',
                'message' => 'Pembelian berhasil diproses. Kepemilikan buku telah tercatat.',
                'transaction_id' => $transaction->id,
                'book_access_link' => $book->link // Asumsi: field 'link' adalah tautan akses/unduh buku
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan jika ada kesalahan
            // Log error untuk debugging internal
            \Illuminate\Support\Facades\Log::error('Kesalahan Pembelian ORX: ' . $e->getMessage(), ['hash' => $request->transaction_hash]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memproses pembelian di server: ' . $e->getMessage()
            ], 500);
        }
    }


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
