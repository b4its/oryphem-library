<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Transaction extends Model
{
    //
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model.
     *
     * @var string
     */   
    protected $table = 'transaction';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idUsers',
        'idBook',
        'transaction_address',
      
    ];

    public function book(): BelongsTo
    {
        // Kita perlu mendefinisikan foreign key secara eksplisit
        // karena nama kolom 'idUsers' tidak mengikuti konvensi Laravel ('user_id').
        return $this->belongsTo(Book::class, 'idBook');
    }

    public function user(): BelongsTo
    {
        // Kita perlu mendefinisikan foreign key secara eksplisit
        // karena nama kolom 'idUsers' tidak mengikuti konvensi Laravel ('user_id').
        return $this->belongsTo(User::class, 'idUsers');
    }
}
