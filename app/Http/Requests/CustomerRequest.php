<?php

namespace App\Http\Requests;

use App\Lib\Helpers;
use App\Models\Customer;
use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng không để trống tên đại lý'
        ];
    }

    public function store()
    {
        $data = $this->all();

        if (! isset($this->status)) {
            $data['status'] = 0;
        }

        $data['district_id'] = Helpers::getDistrictFromAddress($data['address']);

        $customer = Customer::create($data);

        Event::create([
            'content' => 'customers',
            'action' => 'create',
            'user_id' => \Sentinel::getUser()->id,
            'before' => null,
            'after' => json_encode($data, true),
            'content_id' => $customer->id
        ]);

        return $this;
    }

    public function save($id)
    {
        $customer = Customer::findOrFail($id);

        $data = $this->all();

        if (! isset($this->status)) {
            $data['status'] = 0;
        }

        $before = json_encode($customer->toArray(), true);

        $data['district_id'] = Helpers::getDistrictFromAddress($data['address']);

        $customer->update($data);

        Event::create([
            'content' => 'customers',
            'action' => 'edit',
            'user_id' => \Sentinel::getUser()->id,
            'before' => $before,
            'after' => json_encode($data, true),
            'content_id' => $customer->id
        ]);

        return $this;
    }
}
