<?php

namespace App\Domain\Catalog\Navigation\Repositories;

use App\Domain\Catalog\Navigation\Contracts\MasterCategoryRepositoryInterface;
use App\Models\MasterCategory;
use Illuminate\Support\Facades\Cache;

class MasterCategoryRepository implements MasterCategoryRepositoryInterface
{
    private const CACHE_KEY = 'navigation.master_categories';

    public function all(): array
    {
        return Cache::rememberForever(
            self::CACHE_KEY,
            fn() => MasterCategory::query()
                ->select([
                    'id',
                    'name',
                    'slug',
                ])
                ->get()
                ->map(fn($category) => [
                    'id' => (int) $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                ])
                ->all()
        );
    }

    public function find(int $id): ?array
    {
        foreach ($this->all() as $category) {
            if ($category['id'] === $id) {
                return $category;
            }
        }

        return null;
    }
}
