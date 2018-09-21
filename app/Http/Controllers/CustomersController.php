<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CustomersController extends Controller
{

    public function index()
    {
        return view('customers.index');
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(CustomerRequest $request)
    {
        $request->store();

        flash()->success('Thành công!', 'Đã tạo mới đại lý.');

        return redirect()->route('customers.index');
    }

    public function edit($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            throw new ModelNotFoundException('Không tìm thấy đại lý.');
        }

        return view('customers.edit', compact('customer'));
    }

    public function update(CustomerRequest $request, $id)
    {
        $request->save($id);

        flash()->success('Thành công!', 'Cập nhật đại lý thành công!');

        return redirect()->route('customers.index');
    }

    public function dataTables(Request $request)
    {
        return Customer::getDataTables($request);
    }
}