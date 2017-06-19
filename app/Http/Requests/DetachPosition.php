<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Position;

class DetachPosition extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $position = Position::find($this->route('position'));

        return $position && $this->user()->can('detach', $position);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account_id' => 'required',
            'position_id' => 'required',
        ];
    }
}
