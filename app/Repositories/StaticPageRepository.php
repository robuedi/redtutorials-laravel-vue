<?php


namespace App\Repositories;

use App\Models\StaticPage;

class StaticPageRepository implements StaticPageRepositoryInterface
{
    public function getStaticMenu(array $select)
    {
        return StaticPage::withSlug(true)
            ->public(true)
            ->select($select)
            ->get();
    }

    public function getPublicBySlug(string $slug, array $select)
    {
        return StaticPage::where('slug', $slug)
            ->public(true)
            ->select($select)
            ->first();
    }

}
