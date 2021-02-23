<?php


namespace App\Repositories;

use App\Models\StaticPage;

class StaticPageRepository implements StaticPageRepositoryInterface
{
    public function getStaticMenu(){
        return StaticPage::withSlug(true)
            ->public(true)
            ->select('slug', 'name')
            ->get();
    }

}
