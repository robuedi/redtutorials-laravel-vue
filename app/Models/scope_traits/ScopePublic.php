<?php


namespace App\Models\scope_traits;


trait ScopePublic
{
    public function scopePublic($query, $value)
    {
        if($value)
        {
            return $query->where('is_public', 1);
        }

        return $query->where('is_public', 0);
    }
}
