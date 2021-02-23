<?php


namespace App\Models\scope_traits;


trait ScopeDraft
{
    public function scopeDraft($query, $value)
    {
        if($value)
        {
            return $query->where('is_draft', 1);
        }

        return $query->where('is_public', 0);
    }
}
