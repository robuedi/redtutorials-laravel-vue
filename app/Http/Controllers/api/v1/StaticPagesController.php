<?php


namespace App\Http\Controllers\api\v1;


use App\Http\Resources\v1\StaticPagesResource;
use App\Repositories\StaticPageRepositoryInterface;
use Illuminate\Http\Request;

class StaticPagesController
{
    private StaticPageRepositoryInterface $static_page_repository;

    public function __construct(StaticPageRepositoryInterface $static_page_repository)
    {
        $this->static_page_repository = $static_page_repository;
    }

    public function index(Request $request)
    {
        $pages = $this->static_page_repository->getPublic($request->has('fields') ? explode(',', $request->get('fields')) : []);

        return StaticPagesResource::collection($pages);
    }
}
