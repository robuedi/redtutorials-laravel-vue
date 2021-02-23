<?php

namespace App\Repositories;

interface LessonRepositoryInterface
{
    public function getCountTotal();

    public function getCountPublic();

    public function getCountDraft();

    public function getByWeightGrouped();

    public function getPublicLessonsByChapters(array $chapters_ids, array $select_fields = []);
}
