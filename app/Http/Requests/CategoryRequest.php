<?php

namespace App\Http\Requests;

use App\Category;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize() {
        return true;
    }

    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules() {
        return [
            'name' => 'required|string',
            'questions'  => 'required|exists:questions,id',
            'sequence' => 'required|numeric'
        ];
    }

    public function save() {
        switch (request()->method()) {
            case 'POST':
                $category = Category::create([
                    'name' => request('name'),
                    'sequence' => request('sequence'),
                ]);
                $category->questions()->sync(request('questions'));
                break;

            case 'PATCH':
                $this->category->update([
                    'name' => request('name'),
                    'sequence' => request('sequence'),
                ]);
                $this->category->questions()->sync(request('questions'));
                break;

            default:
                break;
        }
    }

    public function messages() {
        return [
            'questions.exists' => 'The selected question(s) is/are invalid.'
        ];
    }
}
