<?php

namespace App\Models;

use App\Models\Chapter;
use App\Models\scope_traits\ScopeDraft;
use App\Models\scope_traits\ScopePublic;
use App\Models\scope_traits\ScopeSlug;
use App\Models\scope_traits\ScopeWeight;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory, ScopePublic, ScopeDraft, ScopeSlug, ScopeWeight;

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'parent_id', 'id');
    }
}
