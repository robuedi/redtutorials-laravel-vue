<?php

namespace App\Models;

use App\Models\Chapter;
use App\Models\scope_traits\ScopeDraft;
use App\Models\scope_traits\ScopePublic;
use App\Models\scope_traits\ScopeSlug;
use App\Models\scope_traits\ScopeWeight;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, ScopeSlug, ScopeDraft, ScopeWeight, ScopePublic;

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
            ->public(true)
            ->weightOrdering()
            ->withSlug(true);
    }


}
