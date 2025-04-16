<?php

namespace App\Repositories;

use App\DTO\CreateCategoryDTO;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    public function findById(int $id): Category {
        return Category::query()->find($id);
    }

    public function findByName(string $name): Category {
        return Category::query()
            ->where('name', $name)
            ->first();
    }

    public function save(CreateCategoryDTO $createCategoryDTO):Category {
        return Category::query()->create([
            "name" => $createCategoryDTO->name,
            "description" => $createCategoryDTO->description,
        ]);
    }

    public function findMany():Collection {
        return Category::query()
            ->orderby("name")
            ->get();
    }

    public function update(Category $category, $updateCategoryDTO): void {
        $category->update(["name" => $updateCategoryDTO->name, "description" => $updateCategoryDTO->description]);
    }

    public function delete(Category $category): void {
        $category->delete();
    }
}
