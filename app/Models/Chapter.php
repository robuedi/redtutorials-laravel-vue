<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\scope_traits\ScopeDraft;
use App\Models\scope_traits\ScopePublic;
use App\Models\scope_traits\ScopeSlug;
use App\Models\scope_traits\ScopeWeight;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory, ScopePublic, ScopeDraft, ScopeSlug, ScopeWeight;

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id','id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'chapter_id', 'id');
    }

    public function publicLessons()
    {
        return $this->lessons()
            ->public(true)
            ->withSlug(true);
    }
}
