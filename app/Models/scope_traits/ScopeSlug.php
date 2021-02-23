<?php


namespace App\Models\scope_traits;

trait ScopeSlug
{
    public function scopeWithSlug($query, $value)
    {
        if($value)
        {
            return $query->whereNotNull('slug');
        }

        return $query->whereNull('slug');
    }
}
