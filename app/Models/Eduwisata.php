<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eduwisata extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'harga',
        'image'
    ];

    public function schedules()
    {
        return $this->hasMany(EduwisataSchedule::class);
    }

}