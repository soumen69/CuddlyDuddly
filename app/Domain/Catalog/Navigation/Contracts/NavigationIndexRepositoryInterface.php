<?php

namespace App\Domain\Catalog\Navigation\Contracts;

interface NavigationIndexRepositoryInterface
{
    /**
     * Cached navigation hierarchy.
     *
     * @return array<int,array<string,mixed>>
     */
    public function all(): array;
}
