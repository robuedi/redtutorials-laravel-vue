<?php

namespace App\Services\Authentication;

interface AuthenticationHelperInterface
{
    public function getUserId(): ?int;

    public function getUserName(): string;

    public function getUserFirstName(): string;

    public function checkIfAdmin(): string;

    public function checkIfClient(): string;

    public function checkIfRoles(array $roles): string;

    public function getUserLogged();

    public function hasAccess(array $type): bool;
}
