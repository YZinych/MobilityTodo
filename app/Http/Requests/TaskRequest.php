<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exception\HttpResponseException;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        $actionName = $this->route()->getActionName();
        $methodName = explode('@', $actionName)[1];

        if ($methodName === 'store') {
            $rules = [
                'title' => 'required|max:255',
                'description' => 'nullable|max:500',
            ];
        }

        if ($methodName === 'update') {
            $rules = [
                'title' => 'required|max:255',
                'description' => 'nullable|max:500',
                'status' => 'required|in:0,1',
            ];
        }

        if ($methodName === 'toggleStatus') {
            $rules = [
                'status' => 'required|in:0,1',
            ];
        }

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
