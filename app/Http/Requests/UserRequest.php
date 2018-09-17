<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Intervention\Image\Facades\Image;

class UserRequest extends FormRequest
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
            'name' => 'required|max:255',
        ];

        if ($this->route('user')) {
            $optionalRules = [
                'email' => 'required|email|max:255|unique:users,email,' . $this->route('user'),
            ];
        } else {
            $optionalRules = [
                'email' => 'required|email|max:255|unique:users',
            ];
        }

        return array_merge($rules, $optionalRules);
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng không để trống tên người dùng',
            'email.required' => 'Vui lòng không để trống email',
            'email.email' => 'Sai định dạng email',
        ];
    }

    public function store()
    {
        $data = $this->all();

        if (! isset($this->status)) {
            $data['status'] = 0;
        }

        if (! isset($this->password)) {
            $data['password'] = md5(time());
        }

        if ($this->hasFile('avatar') && $this->file('avatar')->isValid()) {

            $filename = $this->file('avatar')->getClientOriginalName();

            if (file_exists(public_path('files/'. $filename))) {
                $filename = substr(uniqid(), 0, 4).'_'.$filename;
            }

            Image::make($this->file('avatar')->getRealPath())->save(public_path('files/'. $filename));

            $data['image'] = $filename;
        }


        User::create($data);

        return $this;
    }

    public function save($id)
    {
        $user = User::findOrFail($id);

        $data = $this->all();

        if (! isset($this->status)) {
           $data['status'] = 0;
        }

        if ($this->hasFile('avatar') && $this->file('avatar')->isValid()) {

            $filename = $this->file('avatar')->getClientOriginalName();

            if (file_exists(public_path('files/'. $filename))) {
                $filename = substr(uniqid(), 0, 4).'_'.$filename;
            }

            Image::make($this->file('avatar')->getRealPath())->save(public_path('files/'. $filename));

            $data['image'] = $filename;

        }


        $user->update($data);

        return $this;
    }
}
