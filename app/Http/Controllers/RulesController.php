<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Requests\RuleRequest;
use App\Models\Customer;
use App\Models\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class RulesController extends Controller
{

    public function index()
    {
        return view('rules.index');
    }

    public function create()
    {
        return view('rules.create');
    }

    public function store(RuleRequest $request)
    {
        $request->store();

        flash()->success('Thành công!', 'Đã tạo mới cơ chế.');

        return redirect()->route('rules.index');
    }

    public function edit($id)
    {
        $rule = Rule::find($id);

        if (!$rule) {
            throw new ModelNotFoundException('Không tìm thấy cơ chế.');
        }

        return view('rules.edit', compact('rule'));
    }

    public function update(RuleRequest $request, $id)
    {
        $request->save($id);

        flash()->success('Thành công!', 'Cập nhật cơ chế thành công!');

        return redirect()->route('rules.index');
    }

    public function dataTables(Request $request)
    {
        return Rule::getDataTables($request);
    }
}