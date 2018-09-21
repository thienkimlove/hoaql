<?php

namespace App\Http\Requests;

use App\Lib\Helpers;
use App\Models\Event;
use App\Models\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Validator;

class RuleRequest extends FormRequest
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
            'quantity' => 'required',
            'award' => 'required',
            'salary' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng không để trống tên cơ chế',
            'quantity.required' => 'Vui lòng điền vào số lượng',
            'award.required' => 'Vui lòng điền vào thưởng',
            'salary.required' => 'Vui lòng điền vào lương',
        ];
    }

    public function store()
    {

        $data = $this->all();

        if (! isset($this->status)) {
            $data['status'] = 0;
        }

        foreach (['quantity', 'price', 'salary', 'award'] as $field) {
            $data[$field] = Helpers::convertStringToInt($data[$field]);
        }

        $content = Rule::create($data);

        Event::create([
            'content' => 'rules',
            'action' => 'create',
            'user_id' => \Sentinel::getUser()->id,
            'before' => null,
            'after' => json_encode($data, true),
            'content_id' => $content->id
        ]);

        return $this;
    }

    public function save($id)
    {
        $content = Rule::findOrFail($id);

        $data = $this->all();

        if (! isset($this->status)) {
            $data['status'] = 0;
        }

        foreach (['quantity', 'price', 'salary', 'award'] as $field) {
            $data[$field] = Helpers::convertStringToInt($data[$field]);
        }

        $before = json_encode($content->toArray(), true);

        $content->update($data);

        Event::create([
            'content' => 'rules',
            'action' => 'edit',
            'user_id' => \Sentinel::getUser()->id,
            'before' => $before,
            'after' => json_encode($data, true),
            'content_id' => $content->id
        ]);

        return $this;
    }
}
