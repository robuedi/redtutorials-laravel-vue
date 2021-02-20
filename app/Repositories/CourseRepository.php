<?php


namespace App\Repositories;


use App\Models\Course;
use Illuminate\Support\Facades\Log;

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

    public function getByStatus(array $status = [], array $fields = [])
    {
        return Course::where('status', $status)
            ->select($fields)
            ->orderBy('order_weight')
            ->get();
    }

    public function getByStatusWithSlug(array $status = [], array $fields = [])
    {
        return Course::where('status', $status)
            ->select($fields)
            ->whereNotNull('slug')
            ->orderBy('order_weight')
            ->get();
    }

    public function getBySlug(string $slug, array $status = [])
    {
        return Course::where('slug', $slug)
            ->where('status', $status)
            ->first();
    }

    public function getBySlugWith(string $slug, array $status = [], array $with = [], array $select = [])
    {
        $q = Course::query();
        $q->where('slug', $slug)
            ->whereIn('status', $status)
            ->select($select);

        if($with)
        {
            $q->with($with);
        }

        return $q->first();
    }



}
