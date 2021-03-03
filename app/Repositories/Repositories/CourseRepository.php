<?php


namespace App\Repositories\Repositories;

use App\Models\Course;
use App\Repositories\CourseRepositoryInterface;

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
            ->public(true)
            ->pluck('public')
            ->first();
    }

    public function getCountDraft()
    {
        return Course::selectRaw('COUNT(id) as draft')
            ->draft(true)
            ->pluck('draft')
            ->first();
    }

    public function getByWeight()
    {
        return Course::orderBy('order_weight')
            ->select('id', 'name')
            ->get();
    }

    public function getPublic(array $fields = [])
    {
        return Course::public(true)
            ->select($fields)
            ->weightOrdering()
            ->withSlug(true)
            ->get();
    }

    public function getPublicWithSlug(array $fields = [])
    {
        return Course::public(true)
            ->select($fields)
            ->withSlug(true)
            ->weightOrdering()
            ->get();
    }

    public function getPublicBySlugWith(string $slug, array $with = [], array $select = [])
    {
        $q = Course::query();
        $q->where('slug', $slug)
            ->public(true)
            ->select($select);

        if($with)
        {
            $q->with($with);
        }

        return $q->first();
    }



}
