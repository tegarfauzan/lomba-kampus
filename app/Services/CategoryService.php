<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Str;

class CategoryService
{
    public function __construct(private readonly CategoryRepositoryInterface $categories) {}

    public function store(array $data): Category
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        return $this->categories->create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        return $this->categories->update($category, $data);
    }

    public function destroy(Category $category): bool
    {
        return $this->categories->delete($category);
    }
}
