<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePost extends FormRequest
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
        return [
            'type_of_race' => ['required', 'integer'],
            'type_of_post' => ['required', 'integer', 'in:0,1'],
        //    'price'        => Rule::requiredIf('type_of_user == 0'),
            'post_title'   => ['required', 'string', 'min:2', 'max:60'],
            'race_belonging' => ['required', 'integer', 'in:0,1'],
            'animal_age'     => ['required', 'integer', 'in:0,1,2'],
            'number_litter'  => ['required', 'integer', 'min:0'],
            'animal_id_number' => ['required', 'integer', 'min:0'],
            'is_tattooed_or_chipped' => ['required', 'integer', 'in:0,1'],
            'post_text' => ['required', 'string', 'min:1', 'max:255'],
            'user_position' => ['required', 'string', 'min:3', 'max:255'],
        ];
    }
}
