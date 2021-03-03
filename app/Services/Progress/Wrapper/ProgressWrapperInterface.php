<?php

namespace App\Services\Progress\Wrapper;

interface ProgressWrapperInterface
{
    public function setProgress(array $progress);

    public function getRaw();

    public function setForUser(?int $user_id);

    public function getFor(int $id): ?int;

    public function biggerThan(int $id, int $value);

    public function equalTo(int $id, int $value);
}
