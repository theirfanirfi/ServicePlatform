<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->roles->first()->id === 4;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ship_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'port' => 'required',
            'date' => 'required|required|date_format:d/m/Y',
            'eta' => 'required|date_format:d/m/Y H:i',
            'etb' => 'required|date_format:d/m/Y H:i',
            'etd' => 'required|date_format:d/m/Y H:i',
            'invitation' => 'required',
        ];
    }
}
