<?php

namespace App\Services\Progress\Wrapper;

interface ProgressWrapperInterface
{
    public function setProgress(array $progress): ProgressWrapperInterface;

    public function setPercentage(bool $percentage): ProgressWrapperInterface;

    public function getRaw(): array;

    public function setForUser(?int $user_id): ProgressWrapperInterface;

    public function getFor(int $id): ?int;

    public function biggerThan(int $id, int $value): bool;

    public function equalTo(int $id, int $value): bool;

    public function checkFullyCompleted(): bool;

    public function checkNoneStarted(): bool;
}
