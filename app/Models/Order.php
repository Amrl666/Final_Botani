<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'nama_pemesan', 'telepon', 'jumlah_orang',
        'produk_id', 'eduwisata_id', 'total_harga',
        'status', 'keterangan'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function produk(): BelongsTo {
        return $this->belongsTo(Product::class);
    }

    public function eduwisata(): BelongsTo {
        return $this->belongsTo(Eduwisata::class);
    }
}
