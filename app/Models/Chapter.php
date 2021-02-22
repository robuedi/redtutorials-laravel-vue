<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

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
            ->where('is_public', 1)
            ->whereNotNull('slug');
    }
}
