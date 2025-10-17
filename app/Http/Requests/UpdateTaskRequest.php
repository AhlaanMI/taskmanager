<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $taskId = (int) optional($this->route('task'))->id;

        $rules = [
            'name' => 'required|string|max:255|unique:tasks,name,' . $taskId,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'deadline' => 'required|date|after_or_equal:today',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ];

        if ($this->user() && $this->user()->isAdmin()) {
            $rules['user_id'] = 'required|exists:users,id';
        }

        return $rules;
    }
}
