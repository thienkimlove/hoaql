<?php

namespace App\Http\Controllers;

use App\Lib\Helpers;
use App\Models\Event;
use App\Models\Order;
use App\Models\Product;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Validator;

class OrdersController extends Controller
{
    public $rules = [
        'customer_id' => 'required',
        'customer_name' => 'required',
        'payment_id' => 'required',
        'rule_id' => 'required',
        'quantity' => 'required',
        'price' => 'required',
        ];


    public $messages = [
        'customer_id.required' => 'Xin chọn đại lý',
        'customer_name.required' => 'Xin chọn đại lý',
        'payment_id.required' => 'Xin chọn phương thức thanh toán',
        'rule_id.required' => 'Xin chọn cơ chế',
        'quantity.required' => 'Xin chọn số lượng',
        'price.required' => 'Xin chọn đơn giá',
        ];

    public $sale_fields = [
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_phone',
        'customer_address',
        'payment_id',
        'rule_id',
        'note',
        'quantity',
        'price',
        'total',
        'salary',
        'award',
        'bag_qty',
        'box_qty',
        'gift',
        'note',
    ];

    public $vc_fields = [
        'phi_vc_thu_ho',
        'phi_vc_cty_tra',
        'tien_phai_thu',
        'vc_name',
        'vc_phone',
        'vc_code',
        'holo_term_qty',
        'small_bag_qty',
        'carton_box_qty',
    ];

    public $num_fields = [
        'quantity',
        'price',
        'salary',
        'award',
        'total',
        'box_qty',
        'bag_qty',
        'gift',
        'phi_vc_thu_ho',
        'phi_vc_cty_tra',
        'tien_phai_thu',
        'holo_term_qty',
        'small_bag_qty',
        'carton_box_qty',
    ];


    public function index()
    {
        return view('orders.index');
    }

    public function complete($id)
    {
        $order = Order::find($id);
        if ($order->canComplete()) {
            $order->status = 'complete';
            $order->save();
            flash()->success('Thành công!', 'Đã hoàn thành đơn');
        } else {
            flash()->error('Thất bại!', 'Trạng thái đơn hiện tại là :'.config('system.order_status.'.$order->status).'! Không thể chuyển sang Hoàn thành!');
        }
        return redirect()->back();
    }

    public function delivery($id)
    {
        $order = Order::find($id);

        if ($order->canEditTransportInfo() && $order->vc_user_id && $order->vc_name) {
            $order->status = 'delivery';
            $order->save();
            flash()->success('Thành công!', 'Đơn đã chuyển');
        } else {
            flash()->error('Thất bại!', 'Trạng thái đơn hiện tại là :'.config('system.order_status.'.$order->status));
        }
        return redirect()->back();
    }

    public function move($id)
    {
        $order = Order::find($id);

        if ($order->canEditSaleInfo()) {
            $order->status = 'package';
            $order->save();
            flash()->success('Thành công!', 'Đơn đã chuyển sang vận chuyển');
        } else {
            flash()->error('Thất bại!', 'Trạng thái đơn hiện tại là :'.config('system.order_status.'.$order->status));
        }
        return redirect()->back();
    }

    public function cancel($id)
    {
        $order = Order::find($id);

        if ($order->canCancel()) {
            DB::beginTransaction();
            try {
                $order->status = 'cancel';
                $order->save();
                $order->products()->delete();
                $order->details()->delete();
                DB::commit();
                flash()->success('Thành công!', 'Đơn đã hủy');
            } catch (\Exception $e) {
                DB::rollBack();
                flash()->error('Thất bại!', 'Lỗi xử lý :'.$e->getMessage());
            }

        } else {
            flash()->error('Thất bại!', 'Trạng thái đơn hiện tại là :'.config('system.order_status.'.$order->status));
        }
        return redirect()->back();
    }

    public function return($id)
    {
        $order = Order::find($id);

        if ($order->canReturn()) {
            DB::beginTransaction();
            try {
                $order->status = 'return';
                $order->save();
                $order->products()->delete();
                $order->details()->delete();
                DB::commit();
                flash()->success('Thành công!', 'Đơn đã hoàn');
            } catch (\Exception $e) {
                DB::rollBack();
                flash()->error('Thất bại!', 'Lỗi xử lý :'.$e->getMessage());
            }
        } else {
            flash()->error('Thất bại!', 'Trạng thái đơn hiện tại là :'.config('system.order_status.'.$order->status));
        }
        return redirect()->back();
    }

    public function export(Request $request)
    {
        return Order::exportToExcel($request);
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        //$request->store();
        $dataRequest = $request->all();
        $data = [];
        $data['status'] = 'create';
        $user = \Sentinel::getUser();
        foreach ($this->sale_fields as $sale_field) {
            if (isset($dataRequest[$sale_field])) {
                $data[$sale_field] = (in_array($sale_field, $this->num_fields))? Helpers::convertStringToInt($dataRequest[$sale_field]) : $dataRequest[$sale_field];
            }
        }
        $data['sale_user_id'] = $user->id;
        $validator = Validator::make($data, $this->rules, $this->messages);

        $validator->after(function ($validator) use($data, $user) {
            if (($data['box_qty'] + $data['bag_qty'])!= $data['quantity']) {
                $validator->errors()->add('quantity', 'Tổng số túi và hộp không bằng số lượng tổng!');
            }
            if (!$user->hasAccess('orders')) {
                $validator->errors()->add('quantity', 'Thành viên không có quyền tạo đơn hàng!');
            }
        });

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $order = Order::create($data);

        Event::create([
            'content' => 'orders',
            'action' => 'create',
            'user_id' =>  $user->id,
            'before' => null,
            'after' => json_encode($data, true),
            'content_id' => $order->id
        ]);


        flash()->success('Thành công!', 'Đã tạo mới đơn hàng.');

        return redirect()->route('orders.index');
    }

    public function edit($id)
    {
        $order = Order::find($id);

        if (!$order) {
            throw new ModelNotFoundException('Không tìm thấy đơn hàng.');
        }

        return view('orders.edit', compact('order'));
    }

    public function sale_update(Request $request, $id)
    {
        //$request->save($id);
        $order = Order::findOrFail($id);
        $dataRequest = $request->all();
        $user = \Sentinel::getUser();
        $data = [];
        foreach ($this->sale_fields as $sale_field) {
            if (isset($dataRequest[$sale_field])) {
                $data[$sale_field] = (in_array($sale_field, $this->num_fields))? Helpers::convertStringToInt($dataRequest[$sale_field]) : $dataRequest[$sale_field];
            }
        }

        $validator = Validator::make($data, $this->rules, $this->messages);

        $validator->after(function ($validator) use($data) {
            if (($data['box_qty'] + $data['bag_qty'])!= $data['quantity']) {
                $validator->errors()->add('quantity', 'Tổng số túi và hộp không bằng số lượng tổng!');
            }
        });

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $before = json_encode($order->toArray(), true);
        $order->update($data);

        Event::create([
            'content' => 'orders',
            'action' => 'edit',
            'user_id' => $user->id,
            'before' => $before,
            'after' => json_encode($data, true),
            'content_id' => $order->id
        ]);

        flash()->success('Thành công!', 'Cập nhật thông tin đơn thành công!');

        return redirect()->route('orders.index');
    }


    public function vc_update(Request $request, $id)
    {

        $order = Order::findOrFail($id);
        $dataRequest = $request->all();
        $user = \Sentinel::getUser();
        $data = [];

        foreach ($this->vc_fields as $vc_field) {
            if (isset($dataRequest[$vc_field])) {
                $data[$vc_field] = (in_array($vc_field, $this->num_fields)) ? Helpers::convertStringToInt($dataRequest[$vc_field]) : $dataRequest[$vc_field];
            }
            if (!$order->vc_user_id) {
                $data['vc_user_id'] = $user->id;
            }
        }

        $before = json_encode($order->toArray(), true);
        $order->update($data);

        Event::create([
            'content' => 'orders',
            'action' => 'edit',
            'user_id' => $user->id,
            'before' => $before,
            'after' => json_encode($data, true),
            'content_id' => $order->id
        ]);

        flash()->success('Thành công!', 'Cập nhật vận chuyển thành công!');

        return redirect()->route('orders.index');
    }

    public function dataTables(Request $request)
    {
        return Order::getDataTables($request);
    }
}