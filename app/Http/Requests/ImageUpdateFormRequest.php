<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageUpdateFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|max:125',
            'description' => 'nullable|max:300',
            'image' => 'sometimes|mimetypes:image/jpeg,image/png,image/gif',
        ];
    }
}
