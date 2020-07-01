<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
        return true; # De momento se deja en true para que cualquier usuario pueda utilizar el formulario
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        // dd($this->route('project'));

        return [
            'title' => 'required',
            'url' => [
                'required', 
                // 'unique:projects',
                Rule::unique('projects')->ignore( $this->route('project') )
                
            ],
            // 'image' => ['required','image'],
            'image' => [
                $this->route('project') ? 'nullable' :  'required',
                'mimes:png,jpeg',
                // 'dimensions:min_width=400,min_height:400',
                'max:5000'
            ],//imgage => jpeg, png, bmp, gif, svg o webp
            'description' => 'required'
        ];
    }

    # Agregando mensajes personalizados 
    public function messages()
    {
        return [
            'title.required' => 'El proyecto necesita un título'
        ];
    }
}
