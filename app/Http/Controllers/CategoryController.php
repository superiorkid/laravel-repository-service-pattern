<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function create(CreateCategoryRequest $request): JsonResponse {
        return $this->categoryService->create($request->toDTO());
    }

    public function list(): JsonResponse {
        return $this->categoryService->list();
    }

    public function findById(int $category_id): JsonResponse {
        return $this->categoryService->findOneById($category_id);
    }

    public function update(UpdateCategoryRequest $request, int $category_id): JsonResponse
    {
        return $this->categoryService->update($category_id, $request->toDTO());
    }

    public function delete() {
        //
    }
}
