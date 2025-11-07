<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreate_ReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'SeekerID' => 'required|exists:seekers,UserID',
            'AccommodationID' => 'required|exists:accommodations,AccommodationID',
            'Rating' => 'required|integer|min:1|max:5',
            'Comment' => 'nullable|string|max:1000',
        ];
    }
}
