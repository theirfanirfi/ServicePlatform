<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (auth()->check() && (auth()->user()->roles->first()->id === 3)) || (auth()->check() && (auth()->user()->roles->first()->id === 4));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'imo' => 'required',
            'name' => 'required',
            'mmsi' => 'required',
            'vessel' => 'required',
            'gross_tonnage' => 'required',
            'build' => 'required',
            'flag' => 'required',
            'home_port' => 'required',
        ];
    }
}
