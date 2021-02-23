<?php


namespace App\Models\scope_traits;


trait ScopeWeight
{
    public function scopeWeightOrdering($query)
    {
        return $query->orderBy('order_weight');
    }
}
