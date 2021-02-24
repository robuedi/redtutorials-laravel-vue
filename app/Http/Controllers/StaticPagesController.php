<?php


namespace App\Http\Controllers;


use App\Repositories\StaticPageRepositoryInterface;

class StaticPagesController
{
    private StaticPageRepositoryInterface $static_page_repository;

    public function __construct(StaticPageRepositoryInterface $static_page_repository)
    {
        $this->static_page_repository = $static_page_repository;
    }

    public function index(string $url)
    {
        $page = $this->static_page_repository->getPublicBySlug($url, ['head_title', 'heading', 'content', 'meta_description']);

        //check if we have the page
        if(!$page)
            abort(404);

        return view('static_pages.index', [
            'page' => $page
        ]);
    }
}
