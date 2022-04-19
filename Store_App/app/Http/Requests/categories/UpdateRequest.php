<?php

namespace App\Http\Requests\categories;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
    public function rules($id)
    {
        return [
            'name' =>['required',"unique:categories,name,$id"],
               'parent_id'=>[
                   'nullable','exists:categories,id'
               ] ,
            'description'=>'string|max:255|min:3',
        ];
    }
}
