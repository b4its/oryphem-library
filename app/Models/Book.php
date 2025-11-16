<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    //
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model.
     *
     * @var string
     */   
    protected $table = 'book';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'idCategory',
        'descriptions',
        'link',
        'price',
        'gambar',
        'book_address',
    ];

    public function category(): BelongsTo
    {
        // Kita perlu mendefinisikan foreign key secara eksplisit
        // karena nama kolom 'idUsers' tidak mengikuti konvensi Laravel ('user_id').
        return $this->belongsTo(Category::class, 'idCategory');
    }

    
}
