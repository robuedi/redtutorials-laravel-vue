<?php

namespace App\Models;

use App\Models\Chapter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $morphClass = 'course';

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'course_id', 'id');
    }

    public function mediaFiles()
    {
        return $this->morphToMany(MediaFile::class, 'media_fileable');
    }

    public function mediaFilesMain()
    {
        return $this->morphToMany(MediaFile::class, 'media_fileable')->latest();
    }

    public function publicChapters()
    {
        return $this->chapters()
            ->where('is_public', 1)
            ->orderBy('chapters.order_weight')
            ->whereNotNull('chapters.slug');
    }


}
