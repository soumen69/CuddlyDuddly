<?php

namespace App\Domain\Catalog\Navigation\Contracts;

interface MasterCategoryRepositoryInterface
{
    /**
     * Return all master categories.
     *
     * [
     *   [
     *      'id' => 1,
     *      'name' => 'BOY FASHION',
     *      'slug' => 'boy-fashion',
     *   ]
     * ]
     */
    public function all(): array;

    /**
     * Find a master category.
     */
    public function find(int $id): ?array;
}
