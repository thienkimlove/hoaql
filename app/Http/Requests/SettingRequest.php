<?php

namespace App\Http\Requests;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'value' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng không để trống tên',
            'value.required' => 'Vui lòng không để gía trị',
        ];
    }

    public function store()
    {
        $data = $this->all();

        Setting::updateOrCreate([
            'name' => $data['name']
        ],
            [
                'value' => $data['value']
            ]);

        return $this;
    }

    public function save($id)
    {
        $setting = Setting::findOrFail($id);

        $data = $this->all();


        $setting->update($data);

        return $this;
    }
}
