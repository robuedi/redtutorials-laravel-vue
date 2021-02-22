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
        return $this->morphToMany(MediaFile::class, 'media_fileable')->latest('media_fileables.created_at');
    }

    public function publicChapters()
    {
        return $this->chapters()
            ->where('is_public', 1)
            ->orderBy('order_weight')
            ->whereNotNull('slug');
    }


}
