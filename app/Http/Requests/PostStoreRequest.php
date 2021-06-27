<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PostStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Prepare data for validation
     */
    protected function prepareForValidation()
    {
        if ($this->has('tagged_users')) {
            $this->merge(['tagged_users' => explode(',', $this->tagged_users)]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'title'=>'required|string',
            'description' =>'required|string',
            'tagged_users' => 'sometimes|array|nullable',
            'tagged_users.*' => 'sometimes|exists:users,name'
        ];
    }
}
