<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{

    public function index()
    {
        return view('payments.index');
    }

    public function create()
    {
        return view('payments.create');
    }

    public function store(PaymentRequest $request)
    {
        $request->store();

        flash()->success('Thành công!', 'Đã tạo mới phương thức.');

        return redirect()->route('payments.index');
    }

    public function edit($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            throw new ModelNotFoundException('Không tìm thấy phương thức.');
        }

        return view('payments.edit', compact('payment'));
    }

    public function update(PaymentRequest $request, $id)
    {
        $request->save($id);

        flash()->success('Thành công!', 'Cập nhật phương thức thành công!');

        return redirect()->route('payments.index');
    }

    public function dataTables(Request $request)
    {
        return Payment::getDataTables($request);
    }
}