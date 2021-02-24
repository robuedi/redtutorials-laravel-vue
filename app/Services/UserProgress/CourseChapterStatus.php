<?php


namespace App\Services\UserProgress;

use Illuminate\Support\Collection;

trait CourseChapterStatus
{

    public function getResult(?Collection $children_grouped, array $children_status)
    {
        $response = [];
        // calculate the status by chapter
        foreach ($children_grouped as $parent_id => $children_id)
        {
            $parent_childrens = array_intersect_key($children_status, array_flip($children_id));
            $response[$parent_id] = count($parent_childrens) ? array_sum($parent_childrens)/count($parent_childrens) : 0;
        }

        return $response;
    }
}
