<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /** @use HasFactory<\Database\Factories\VideoFactory> */
    use HasFactory;
    protected $fillable = [
        'name', 'title', 'video', 'description'
    ];

    // Get video aspect ratio class
    public function getAspectClass()
    {
        return 'aspect-video';
    }
}
