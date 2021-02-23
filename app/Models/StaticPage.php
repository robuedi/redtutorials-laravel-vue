<?php

namespace App\Models;

use App\Models\scope_traits\ScopePublic;
use App\Models\scope_traits\ScopeSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    use HasFactory, ScopeSlug, ScopePublic;
}
