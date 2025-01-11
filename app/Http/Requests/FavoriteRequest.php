<?php

namespace App\Http\Requests;

use App\Rules\ValidGiphy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FavoriteRequest extends FormRequest
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
            'gif_id' => ['required', new ValidGiphy()],
            'alias' => ['required'],
            'user_id' => ['required', 'integer','exists:users,id', 'same:current_user_id'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'current_user_id' => Auth::id(),
        ]);
    }
}
