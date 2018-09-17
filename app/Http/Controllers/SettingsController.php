<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function index()
    {
        return view('settings.index');
    }

    public function create()
    {
        return view('settings.create');
    }

    public function store(SettingRequest $request)
    {
        $request->store();

        flash()->success('Success!', 'Setting successfully created.');

        return redirect()->route('settings.index');
    }

    public function edit($id)
    {
        $setting = Setting::find($id);

        if (! $setting) {
            throw new ModelNotFoundException('Setting not found.');
        }

        return view('settings.edit', compact('setting'));
    }

    public function update(SettingRequest $request, $id)
    {
        $request->save($id);

        flash()->success('Thành công', 'Cập nhật thành công!');

        return redirect()->route('settings.index');
    }

    public function dataTables(Request $request)
    {
        return Setting::getDatatables($request);
    }

}