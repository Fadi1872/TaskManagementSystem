<?php

namespace App\Http\Requests;

use App\Models\Priority;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePriorityRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', Priority::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $priorityId = $this->route('priority')->getKey();

        return [
            'name' => [
                'required',
                'string',
                'max:40',
                Rule::unique('priorities', 'name')->ignore($priorityId),
            ],
            'level' => ["required", 'integer', 'min:1', 'max:20']
        ];
    }
}
