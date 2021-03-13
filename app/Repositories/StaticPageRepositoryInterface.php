<?php

namespace App\Repositories;

interface StaticPageRepositoryInterface
{
    public function getPublic(array $select);
    public function getPublicBySlug(string $slug, array $select);
}
