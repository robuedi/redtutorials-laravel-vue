<?php

namespace App\Repositories;

interface LessonRepositoryInterface
{
    public function getCountTotal();

    public function getCountPublic();

    public function getCountDraft();

    public function getByWeightGrouped();
}
