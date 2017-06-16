<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Account;

class UpdateAccount extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      $account = Account::find($this->route('account'));

      return $account && $this->user()->can('update', $account);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required',
            'name' => 'required',
            'batchable' => 'required',
        ];
    }
}
