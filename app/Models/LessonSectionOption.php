<?php

namespace App\Models;

use App\Models\scope_traits\ScopePublic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonSectionOption extends Model
{
    use HasFactory, ScopePublic;

    public function lessonSection()
    {
        return $this->belongsTo(LessonSection::class, 'lesson_section_id', 'id');
    }
}
