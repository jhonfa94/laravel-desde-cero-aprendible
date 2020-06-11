<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'title' => 'required',
            'url' => 'required',
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
