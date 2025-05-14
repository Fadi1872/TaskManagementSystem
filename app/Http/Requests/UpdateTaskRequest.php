<?php

namespace App\Http\Requests;

use App\Models\Task;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends BaseRequest
{
    /**
     * checks if the date is formatted in the provided format
     * 
     * @param string $date
     * @param string $format
     * @return bool
     */
    protected function isValidDateFormat($date, $format)
    {
        try {
            $parsed = Carbon::createFromFormat($format, $date);
            return $parsed && $parsed->format($format) === $date;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * checks if the date is formatted in m/d/y and chaange it to y-m-d
     * 
     * @param string $date
     * @return string
     */
    protected function normalizeDate($date)
    {
        if ($this->isValidDateFormat($date, 'Y-m-d'))
            return $date;

        try {
            $date = Carbon::createFromFormat("m/d/Y", $date);
            if ($date) {
                return $date->format('Y-m-d');
            }
        } catch (\Exception $e) {
        }

        return $date;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'start_date' => $this->normalizeDate($this->start_date),
            'due_date' => $this->normalizeDate($this->due_date),
        ]);
    }
    
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', Task::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:10000'],
            'status_id' => ['required', 'exists:statuses,id'],
            'priority_id' => ['required', 'exists:priorities,id'],
            'created_by' => ['required', 'exists:users,id'],
            "start_date" => ['required', 'date'],
            "due_date" => ['required', 'date', 'after_or_equal:start_date'],
            "completed_at" => ['nullable', 'date', 'after_or_equal:start_date'],
            "assigned_users" => ['nullable', 'array'],
            "assigned_users.*" => ['exists:users,id']
        ];
    }
}
