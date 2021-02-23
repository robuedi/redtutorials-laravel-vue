<?php

namespace App\Models;

use App\Models\scope_traits\ScopePublic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonSection extends Model
{
    use HasFactory, ScopePublic;

    protected $table = 'lesson_sections';

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
