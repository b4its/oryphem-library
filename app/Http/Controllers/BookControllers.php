<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

use function Termwind\render;

class BookControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function api_getBook_all()
    {
        $books = Book::all();

        // 2. Laravel akan mengkonversi koleksi Eloquent ini secara otomatis
        //    menjadi JSON, yang mencakup semua kolom (termasuk id, created_at, updated_at).
        //    'content' (yang menyimpan tech sebagai string) dan 'idCategory' serta 'price'
        //    akan ikut terkirim.
        
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
