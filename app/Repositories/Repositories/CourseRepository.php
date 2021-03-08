<?php


namespace App\Repositories\Repositories;

use App\Models\Course;
use App\Repositories\CourseRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class CourseRepository implements CourseRepositoryInterface
{
    private Course $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function getCountTotal()
    {
        return $this->course->selectRaw('COUNT(id) as total')
            ->pluck('total')
            ->first();
    }

    public function getCountPublic()
    {
        return $this->course->selectRaw('COUNT(id) as public')
            ->public(true)
            ->pluck('public')
            ->first();
    }

    public function getCountDraft()
    {
        return $this->course->selectRaw('COUNT(id) as draft')
            ->draft(true)
            ->pluck('draft')
            ->first();
    }

    public function getByWeight()
    {
        return $this->course->orderBy('order_weight')
            ->select('id', 'name')
            ->get();
    }

    public function getPublic(array $fields = [])
    {
        return Cache::remember(__CLASS__.__METHOD__.implode('', $fields),3600, function() use ($fields) {
            return $this->course->public(true)
                ->select($fields)
                ->weightOrdering()
                ->withSlug(true)
                ->get();
        });
    }

    public function getPublicWithSlug(array $fields = [])
    {
        return Cache::remember(__CLASS__.__METHOD__.implode('', $fields),3600, function() use ($fields) {
            return $this->course->public(true)
                ->select($fields)
                ->withSlug(true)
                ->weightOrdering()
                ->get();
        });
    }

    public function getPublicBySlugWith(string $slug, array $with = [], array $select = [])
    {
        return Cache::remember(__CLASS__.__METHOD__.$slug.implode('', $with).implode('', $select),3600, function() use ($slug, $with, $select) {
            $q = $this->course::query();
            $q->where('slug', $slug)
                ->public(true)
                ->select($select);

            if($with)
            {
                $q->with($with);
            }

            return $q->first();
        });
    }
}
