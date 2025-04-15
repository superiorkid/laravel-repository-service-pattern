<?php

namespace App\Services;

use App\DTO\CreateCategoryDTO;
use App\DTO\UpdateCategoryDTO;
use App\Repositories\CategoryRepository;
use Illuminate\Http\JsonResponse;

class CategoryService
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function create(CreateCategoryDTO $createCategoryDTO): JsonResponse{
        $category = $this->categoryRepository->findByName($createCategoryDTO->name);
        if($category){
            return response()->json(["success" => false, "message" => "Category already exists"], 409);
        }

        try {
            $this->categoryRepository->save($createCategoryDTO);
            return response()->json(["success" => true, "message" => "Category created"], 201);
        } catch (\Exception $error) {
            return response()->json(["success" => false, "message" => $error->getMessage()], 500);
        }
    }

    public function list(): JsonResponse {
        try {
            $categories = $this->categoryRepository->findMany();
            return response()->json(["success" => true, "message" => "Category list", "data" => $categories], 200);
        } catch (\Exception $error) {
            return response()->json(["success" => false, "message" => $error->getMessage()], 500);
        }
    }

    public function findOneById(int $id): JsonResponse {
        try {
            $category = $this->categoryRepository->findById($id);
            return response()->json(["success" => true, "message" => "Category found", "data" => $category], 200);
        } catch (\Exception $error) {
            return response()->json(["success" => false, "message" => $error->getMessage()], 500);
        }
    }

    public function update(int $id, UpdateCategoryDTO $updateCategoryDTO): JsonResponse {
        $category = $this->categoryRepository->findById($id);
        if (!$category) {
            return response()->json(["success" => false, "message" => "Category not found"], 404);
        }

        try {
            $this->categoryRepository->update($category, $updateCategoryDTO);
            return response()->json(["success" => true, "message" => "Category updated"], 200);
        } catch (\Exception $error) {
            return response()->json(["success" => false, "message" => $error->getMessage()], 500);
        }
    }
}
