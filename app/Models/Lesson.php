<?php

namespace App\Models;

use App\Models\scope_traits\ScopeDraft;
use App\Models\scope_traits\ScopePublic;
use App\Models\scope_traits\ScopeSlug;
use App\Models\scope_traits\ScopeWeight;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Lesson extends Model
{
    use HasFactory, ScopePublic, ScopeDraft, ScopeSlug, ScopeWeight;

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id', 'id');
    }

    public function lessonSections()
    {
        return $this->hasMany(LessonSection::class, 'lesson_id', 'id');
    }

    public function publicLessonSections()
    {
        return $this->lessonSections()
            ->orderBy('order_weight')
            ->public(true);
    }

    public function publicChapter()
    {
        return $this->chapter()->public(true);
    }

    public function nextSlug(){
        // get next lesson
        return $this->next(['slug']);

    }

    public function next(array $select = []){
        // get next lesson
        return Cache::remember(__CLASS__.__METHOD__.implode('', $select),3600, function() use ($select) {
            return $this->orderBy('order_weight')
                ->where('order_weight', '>', $this->order_weight)
                ->where('chapter_id', '>', $this->chapter_id)
                ->select($select)
                ->public(true)
                ->withSlug(true)
                ->first();
        });
    }
}
