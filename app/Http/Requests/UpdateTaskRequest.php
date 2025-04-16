<?php

namespace App\Http\Requests;

use App\DTO\UpdateTaskDTO;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
      return [
          "title" => "nullable|string",
          "description" => "nullable|string",
          "category_id" => "nullable|integer|exists:categories,id",
          "status" => ["nullable", Rule::enum(TaskStatus::class)],
          "priority" => ["nullable", Rule::enum(TaskPriority::class)],
          "due_date" => "nullable|date",
          "completed_at" => "nullable|date",
      ];
    }

    public function toDTO(): UpdateTaskDTO {
        return new UpdateTaskDTO(
            title: $this->title,
            description: $this->description,
            category_id: $this->category_id,
            status: $this->status,
            priority: $this->priority,
            due_date: $this->due_date,
            completed_at: $this->completed_at
        );
    }
}
