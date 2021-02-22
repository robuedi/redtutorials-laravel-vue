<?php

namespace App\Repositories;

interface LessonRepositoryInterface
{
    public function getCountTotal();

    public function getCountPublic();

    public function getCountDraft();

    public function getByWeightGrouped();

    public function getLessonsByChapters(array $chapters_ids, int $public = 1, array $select_fields = []);
}
