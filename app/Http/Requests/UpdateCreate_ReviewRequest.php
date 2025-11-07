<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCreate_ReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'SeekerID' => 'sometimes|required|exists:seekers,UserID',
            'AccommodationID' => 'sometimes|required|exists:accommodations,AccommodationID',
            'Rating' => 'sometimes|required|integer|min:1|max:5',
            'Comment' => 'nullable|string|max:1000',
        ];
    }
}
