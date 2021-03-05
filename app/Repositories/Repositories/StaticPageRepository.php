<?php


namespace App\Repositories\Repositories;

use App\Models\StaticPage;
use App\Repositories\StaticPageRepositoryInterface;

class StaticPageRepository implements StaticPageRepositoryInterface
{
    private StaticPage $static_page;

    public function __construct(StaticPage $static_page)
    {
        $this->static_page = $static_page;
    }

    public function getStaticMenu(array $select)
    {
        return $this->static_page->withSlug(true)
            ->public(true)
            ->select($select)
            ->get();
    }

    public function getPublicBySlug(string $slug, array $select)
    {
        return $this->static_page->where('slug', $slug)
            ->public(true)
            ->select($select)
            ->first();
    }

}
