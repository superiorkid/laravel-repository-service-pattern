<?php

namespace App\Http\Requests;

use App\DTO\CreateTaskDTO;
use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
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
            "title" => "required|string",
            "description" => "nullable|string",
        ];
    }

    public function toDTO(): CreateTaskDTO {
        return new CreateTaskDTO(
            title: $this->title,
            description: $this->description
        );
    }
}
