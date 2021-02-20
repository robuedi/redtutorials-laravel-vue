<?php

namespace App\Repositories;

interface CourseRepositoryInterface
{
    public function getCountTotal();

    public function getCountPublic();

    public function getCountDraft();

    public function getByWeight();
}
