<?php


namespace App\Repositories;


use App\Models\Course;

class CourseRepository implements CourseRepositoryInterface
{
    public function getCountTotal()
    {
        return Course::selectRaw('COUNT(id) as total')
            ->pluck('total')
            ->first();
    }

    public function getCountPublic()
    {
        return Course::selectRaw('COUNT(id) as public')
            ->where('status', 1)
            ->pluck('public')
            ->first();
    }

    public function getCountDraft()
    {
        return Course::selectRaw('COUNT(id) as draft')
            ->where('is_draft', 1)
            ->pluck('draft')
            ->first();
    }

    public function getByWeight()
    {
        return Course::orderBy('order_weight')
            ->select('id', 'name')
            ->get();
    }
}
