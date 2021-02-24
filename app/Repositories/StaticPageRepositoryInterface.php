<?php

namespace App\Repositories;

interface StaticPageRepositoryInterface
{
    public function getStaticMenu(array $select);
    public function getPublicBySlug(string $slug, array $select);
}
