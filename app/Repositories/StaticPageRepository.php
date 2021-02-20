<?php


namespace App\Repositories;

use App\Models\StaticPage;

class StaticPageRepository implements StaticPageRepositoryInterface
{
    public function getStaticMenu(){
        return StaticPage::where('slug', '!=', '')
            ->where('is_public', 1)
            ->select('slug', 'name')
            ->get();
    }

}
