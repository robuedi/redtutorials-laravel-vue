<?php

namespace App\Models;

use App\Models\Chapter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'parent_id', 'id');
    }
}
