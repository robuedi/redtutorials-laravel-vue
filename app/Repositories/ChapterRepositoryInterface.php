<?php


namespace App\Repositories;


interface ChapterRepositoryInterface
{
    public function getCountTotal();

    public function getCountPublic();

    public function getCountDraft();
}
