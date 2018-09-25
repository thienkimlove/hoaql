<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Order;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;
use Validator;

class DetailsController extends Controller
{

    public $rules = [
        'order_id' => 'required',
        'is_manually' => 'required',
    ];
    public $messages = [
        'order_id.required' => 'Xin chọn đơn hàng',
        'is_manually.required' => 'Xin chọn loại nhập mã',
    ];

    public function customValidate($request)
    {
        $data = $request->all();
        $re = '/A\d{8}/';
        $added_items = [];
        if (!isset($data['order_id'])) {
            return 'Không có thông tin đơn hàng!';
        }
        $order = Order::find($data['order_id']);
        if (!$order) {
            return 'Không có thông tin đơn hàng!';
        }
        $total_added_products = Product::where('order_id', $order->id)->count();
        if ($data['is_manually']) {
            if (!$data['manually_items']) {
                return 'Chưa nhập danh sách mã lẻ!';
            }
            $added_items = explode("\n", $data['manually_items']);
            $error_items = [];
            foreach ($added_items as $added_item) {
                if (!preg_match($re, $added_item)) {
                    $error_items[] = $added_item;
                }
            }
            if ($error_items) {
                return 'Có định dạng mã lẻ không hợp lệ!'.implode(',', $error_items);
            }

            if ($order->quantity < ($total_added_products + count($added_items))) {
                return 'Danh sách mã lẻ nhập thừa so với số lượng sản phẩm trong đơn! (Đã nhập : '.$total_added_products.' - Định nhập thêm : '.count($added_items).' - Số lượng sản phẩm trong đơn : '.$order->quantity.')';
            }
        } else {
            if (!$data['start_code']) {
                return 'Chưa nhập mã bắt đầu!';
            }
            if (!$data['end_code']) {
                return 'Chưa nhập mã kết thúc!';
            }
            if (!preg_match($re, $data['start_code'])) {
                return 'Định dạng mã bắt đầu không hợp lệ!';
            }
            if (!preg_match($re, $data['end_code'])) {
                return 'Định dạng mã kết thúc không hợp lệ!';
            }

            $temp_start = str_replace('a', '1', trim(strtolower($data['start_code'])));
            $temp_start = intval($temp_start);


            $temp_end = str_replace('a', '1', trim(strtolower($data['end_code'])));
            $temp_end = intval($temp_end);

            if ($temp_start > $temp_end) {
                return 'Mã bắt đầu lớn hơn mã kết thúc!';
            }

            if ($temp_start == $temp_end) {
                return 'Mã bắt đầu giống mã kết thúc!';
            }

            if ($order->quantity < ($total_added_products + ($temp_end - $temp_start))) {
                return 'Danh sách mã nhập thừa so với số lượng sản phẩm trong đơn! (Đã nhập : '.$total_added_products.' - Định nhập thêm : '.($temp_end - $temp_start).' - Số lượng sản phẩm trong đơn : '.$order->quantity.')';
            }

            for ($i = 0; $i <= ($temp_end - $temp_start); $i++) {
                $added_items[] = "A".substr(strval($temp_start+$i), 1);
            }
        }
        $added_items = array_unique($added_items);
        if (!$added_items) {
            return 'Danh sách mã sản phẩm rỗng!';
        }
        $countSameProductItems = Product::whereIn('code', $added_items)->get();

        if ($countSameProductItems->count() > 0) {
            $existedItems = [];
            foreach ($countSameProductItems as $countSameProductItem) {
                $existedItems[] = $countSameProductItem->code;
            }
            if ($existedItems) {
                return 'Có các mã đã tồn tại trong hệ thống! Đã tồn tại :'.implode(',', $existedItems);
            }
        }

        DB::beginTransaction();
        try {

            $detail = Detail::create($data);
            foreach ($added_items as $added_item) {
                Product::create([
                    'order_id' => $order->id,
                    'detail_id' => $detail->id,
                    'code' => $added_item
                ]);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return 'Lỗi thực thi : '.$e->getMessage();
        }

        return null;
    }


    public function store(Request $request)
    {
        $errorMsg = $this->customValidate($request);
        if ($errorMsg) {
           return response()->json(['error' => $errorMsg]);
        } else {
           return response()->json(['success' => 'Đã tạo mới một danh sách mã sản phẩm cho đơn hàng!']);
        }
    }

    public function delete($id)
    {
        $detail = Detail::find($id);

        if ($detail) {

            if (!$detail->order->canEditTransportInfo()) {
                flash()->error('Thất bại!', 'Trạng thái đơn hiện tại không thể thực hiện hành động này!');
            }
            DB::beginTransaction();
            try {
                Product::where('detail_id', $detail->id)->delete();

                $detail->delete();

                DB::commit();

                flash()->success('Thành công!', 'Đã xóa dòng nhập mã này!');

            } catch (\Exception $e) {
                DB::rollBack();
                flash()->error('Thất bại!', 'Lỗi thực thi : '.$e->getMessage());
            }
        } else {
            flash()->error('Thất bại!', 'Không tìm thấy thông tin tương ứng!');
        }
        return redirect()->back();
    }


    public function dataTables(Request $request)
    {
        return Detail::getDataTables($request);
    }
}