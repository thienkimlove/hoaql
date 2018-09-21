<?php

namespace App\Http\Requests;

use App\Models\Event;
use App\Models\Payment;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'name.required' => 'Vui lòng không để trống tên'
        ];
    }

    public function store()
    {
        $data = $this->all();

        if (! isset($this->status)) {
            $data['status'] = 0;
        }

        $payment = Payment::create($data);

        Event::create([
            'content' => 'payments',
            'action' => 'create',
            'user_id' => \Sentinel::getUser()->id,
            'before' => null,
            'after' => json_encode($data, true),
            'content_id' => $payment->id
        ]);

        return $this;
    }

    public function save($id)
    {
        $payment = Payment::findOrFail($id);

        $data = $this->all();

        if (! isset($this->status)) {
            $data['status'] = 0;
        }

        $before = json_encode($payment->toArray(), true);
        $payment->update($data);

        Event::create([
            'content' => 'payments',
            'action' => 'edit',
            'user_id' => \Sentinel::getUser()->id,
            'before' => $before,
            'after' => json_encode($data, true),
            'content_id' => $payment->id
        ]);

        return $this;
    }
}
