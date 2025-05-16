<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EduwisataSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'eduwisata_id',
        'date',
        'time',
        'max_participants'
    ];

    public function eduwisata()
    {
        return $this->belongsTo(Eduwisata::class);
    }
}