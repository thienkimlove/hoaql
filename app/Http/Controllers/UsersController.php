<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Sentinel;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{

    public function index()
    {
        return view('users.index');
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        $request->store();

        flash()->success('Success!', 'User successfully created.');

        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $user = Sentinel::findById($id);

        if (! $user) {
            throw new ModelNotFoundException('User not found.');
        }

        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, $id)
    {
        $request->save($id);

        flash()->success('Thành công', 'Cập nhật thành công!');

        return redirect()->route('users.index');
    }

    public function dataTables(Request $request)
    {
        return User::getDatatables($request);
    }

}