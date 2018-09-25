<?php

namespace App\Models;


use App\Lib\Helpers;
use Carbon\Carbon;
use DataTables;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_phone',
        'customer_address',
        'sale_user_id',
        'payment_id',
        'rule_id',
        'code',
        'quantity',
        'price',
        'total',
        'salary',
        'award',
        'bag_qty',
        'box_qty',
        'gift',
        'note',
        'vc_user_id',
        'phi_vc_thu_ho',
        'phi_vc_cty_tra',
        'tien_phai_thu',
        'vc_name',
        'vc_phone',
        'vc_code',
        'status',
        'small_bag_qty',
        'carton_box_qty',
        'holo_term_qty',
    ];

    public function isCreate()
    {
        return $this->status == 'create';
    }

    public function isPackage()
    {
        return $this->status == 'package';
    }

    public function isDelivery()
    {
        return $this->status == 'delivery';
    }

    public function isComplete()
    {
        return $this->status == 'complete';
    }

    public function isReturn()
    {
        return $this->status == 'return';
    }

    public function isCancel()
    {
        return $this->status == 'cancel';
    }

    public function canComplete()
    {
        return  $this->isDelivery();
    }


    public function canCancel()
    {
        return ($this->isCreate() || $this->isPackage());
    }

    public function canReturn()
    {
        return ($this->isDelivery() || $this->isComplete());
    }

    public function canEditSaleInfo()
    {
        return $this->isCreate();
    }

    public function canEditTransportInfo()
    {
        return $this->isPackage();
    }



    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function sale_user()
    {
        return $this->belongsTo(User::class, 'sale_user_id', 'id');
    }

    public function vc_user()
    {
        return $this->belongsTo(User::class, 'vc_user_id', 'id');
    }

    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function details()
    {
        return $this->hasMany(Detail::class);
    }


    public static function getDataTables($request)
    {

        $user = \Sentinel::getUser();

        $content = static::select('*');

        return DataTables::of($content)
            ->filter(function ($query) use ($request) {
                if ($request->filled('code')) {
                    $query->where('code', 'like', '%' . $request->get('code') . '%');
                }

                if ($request->filled('status')) {
                    $query->where('status', $request->get('status'));
                }

                if ($request->filled('date')) {
                    $dateRange = explode('-', $request->get('date'));
                    $query->whereDate('created_at', '>=', Carbon::createFromFormat('d/m/Y', trim($dateRange[0]))->toDateString());
                    $query->whereDate('created_at', '<=', Carbon::createFromFormat('d/m/Y', trim($dateRange[1]))->toDateString());
                }

                if ($request->filled('vc_code')) {
                    $query->where('vc_code', $request->get('vc_code'));
                }

                if ($request->filled('vc_name')) {
                    $query->where('vc_name', $request->get('vc_name'));
                }

                if ($request->filled('customer_code')) {
                    $customer_code = $request->get('customer_code');
                    $query->whereHas('customer', function($q) use ($customer_code){
                        $q->where('code', $customer_code);
                    });
                }

            })
            ->addColumn('action', function ($content) use ($user) {

                $response = null;

                if (($content->canEditSaleInfo() && $user->hasAccess(['orders']))) {
                    $response .= '<a class="table-action-btn" title="Cập nhật thông tin đơn hàng" href="' . route('orders.edit', $content->id) . '"><i class="fa fa-pencil text-success"></i></a>';

                    $response .= '<a class="table-action-btn" id="btn-move-' . $content->id . '" title="Chuyển cho nhân viên vận chuyển" data-url="' . route('orders.move', $content->id) . '" href="javascript:;"><i class="fa fa-paste text-warning"></i></a>';
                }


                if ($content->canEditTransportInfo() && $user->hasAccess(['transports'])) {
                     $response .= '<a class="table-action-btn" title="Cập nhật thông tin vận chuyển" href="' . route('orders.edit', $content->id) . '"><i class="fa fa-pencil text-success"></i></a>';

                     if ($content->vc_user_id && $content->vc_name) {
                         $response .= '<a class="table-action-btn" id="btn-delivery-' . $content->id . '" title="Đánh dấu đơn đã chuyển" data-url="' . route('orders.delivery', $content->id) . '" href="javascript:;"><i class="fa fa-subway text-warning"></i></a>';
                     }
                 }

                if ($content->canComplete() && $user->hasAccess(['orders'])) {
                    $response .= '<a class="table-action-btn" id="btn-complete-' . $content->id . '" title="Hoàn thành đơn" data-url="' . route('orders.complete', $content->id) . '" href="javascript:;"><i class="fa fa-check text-success"></i></a>';
                }


                if ($content->canCancel() && $user->hasAccess(['orders'])) {
                    $response .= '<a class="table-action-btn" id="btn-cancel-' . $content->id . '" title="Hủy đơn" data-url="' . route('orders.cancel', $content->id) . '" href="javascript:;"><i class="fa fa-remove text-danger"></i></a>';
                }

                if ($content->canReturn() && $user->hasAccess(['orders'])) {
                    $response .= '<a class="table-action-btn" id="btn-return-' . $content->id . '" title="Hoàn đơn" data-url="' . route('orders.return', $content->id) . '" href="javascript:;"><i class="fa fa-backward text-danger"></i></a>';
                }

                return $response;

            })
            ->addColumn('customer_info', function($content){
                return '<p><b>Tên : </b>'.$content->customer_name.' (Mã:'.$content->customer->code.')'.'<br/><b>SDT : </b>'.$content->customer_phone.'<br/><b>Địa chỉ : </b>'.$content->customer_address.'<br/></p>';
            })

            ->addColumn('order', function($content){
                return '<p><b>Số lượng : </b>'.Helpers::vn_price($content->quantity, true).'<br/><b>Đơn giá : </b>'.Helpers::vn_price($content->price).'<br/><b>Số túi : </b>'.Helpers::vn_price($content->bag_qty, true).'<br/><b>Số hộp : </b>'.Helpers::vn_price($content->box_qty, true).'<br/><b>Số túi nilon : </b>'.Helpers::vn_price($content->small_bag_qty, true).'<br/><b>Số thùng carton : </b>'.Helpers::vn_price($content->carton_box_qty, true).'<br/><b>Số tem holo : </b>'.Helpers::vn_price($content->holo_term_qty, true).'<br/><b>Khuyến mãi : </b>'.Helpers::vn_price($content->gift, true).'<br/><b>Lương : </b>'.Helpers::vn_price($content->salary).'<br/><b>Thưởng : </b>'.Helpers::vn_price($content->award).'<br/></p>';
            })

            ->addColumn('transport', function($content){
                return '<p><b>Phí VC thu hộ : </b>'.Helpers::vn_price($content->phi_vc_thu_ho).'<br/><b>Phí VC công ty trả : </b>'.Helpers::vn_price($content->phi_vc_cty_tra).'<br/><b>Tiền phải thu : </b>'.Helpers::vn_price($content->tien_phai_thu).'<br/><b>Đơn vị vận chuyển : </b>'.$content->vc_name.'<br/><b>Mã vận chuyển : </b>'.$content->vc_code.'<br/><b>SDT đơn vị vận chuyển : </b>'.$content->vc_phone.'<br/></p>';
            })

            ->editColumn('total', function($content){
                return Helpers::vn_price($content->total);
            })

            ->addColumn('histories', function ($content) {
                $histories = '';

                $logs = Event::where('content', 'orders')
                    ->where('content_id', $content->id)
                    ->latest('created_at')
                    ->limit(3)
                    ->get();

                if ($logs->count() > 0) {
                    foreach ($logs as $log) {
                        $action = ($log->action == 'edit') ? 'Sửa' : 'Tạo';
                        $histories .= '<b>'.$log->user->name.'</b> '.$action.'&nbsp;&nbsp;<span style="background-color: #e3e3e3">' . $log->created_at->toDayDateTimeString() . '</span><br/>';
                    }
                }

                return $histories;
            })
            ->editColumn('created_at', function($content){
                return $content->created_at->format('d/m/Y');
            })

            ->editColumn('status', function ($content) {
                return config('system.order_status.'.$content->status);
            })
            ->rawColumns(['action', 'status', 'histories', 'customer_info', 'order', 'transport'])
            ->make(true);
    }


    public static function exportToExcel($request)
    {
        ini_set('memory_limit', '2048M');

        $query = static::select('*')->latest('created_at');

        if ($request->filled('filter_code')) {
            $query->where('code', 'like', '%' . $request->get('filter_code') . '%');
        }

        if ($request->filled('filter_network_id')) {
            $query->where('network_id', $request->get('filter_network_id'));
        }


        if ($request->filled('filter_status')) {
            $query->where('status', $request->get('filter_status'));
        }

        if ($request->filled('filter_date')) {
            $dateRange = explode('-', $request->get('filter_date'));
            $query->whereDate('created_at', '>=', Carbon::createFromFormat('d/m/Y', trim($dateRange[0]))->toDateString());
            $query->whereDate('created_at', '<=', Carbon::createFromFormat('d/m/Y', trim($dateRange[1]))->toDateString());
        }

        if ($request->filled('filter_vc_code')) {
            $query->where('vc_code', $request->get('filter_vc_code'));
        }

        if ($request->filled('filter_vc_name')) {
            $query->where('vc_name', $request->get('filter_vc_name'));
        }

        if ($request->filled('filter_customer_code')) {
            $customer_code = $request->get('filter_customer_code');
            $query->whereHas('customer', function($q) use ($customer_code){
                $q->whereIn('code', $customer_code);
            });
        }

        $reports = $query->get();

        return (new static())->createExcelFile($reports);
    }

    public function createExcelFile($reports)
    {
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load(resource_path('templates/orders.xlsx'));

        $row = 2;
        foreach ($reports as $report) {

            $tructhuoc = isset($report->customer->parent)? ' - Trực thuộc : '.$report->customer->parent->name : '';

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $row - 1)
                ->setCellValue('B'.$row, $report->created_at->format('d/m/Y'))
                ->setCellValue('C'.$row, $report->code)
                ->setCellValue('D'.$row, $report->customer_name.' (Mã : '.$report->customer->code.') - '.$report->customer_phone.' - '.$report->customer_address. $tructhuoc)
                ->setCellValue('E'.$row, number_format($report->quantity))

                ->setCellValue('F'.$row, number_format($report->box_qty))
                ->setCellValue('G'.$row, number_format($report->bag_qty))
                ->setCellValue('H'.$row, number_format($report->small_bag_qty))

                ->setCellValue('I'.$row, number_format($report->carton_box_qty))
                ->setCellValue('J'.$row, number_format($report->holo_term_qty))
                ->setCellValue('K'.$row, number_format($report->gift))

                ->setCellValue('L'.$row, number_format($report->price))
                ->setCellValue('M'.$row, number_format($report->total))
                ->setCellValue('N'.$row, $report->sale_user->name)

                ->setCellValue('O'.$row, number_format($report->phi_vc_thu_ho))
                ->setCellValue('P'.$row, number_format($report->phi_vc_cty_tra))
                ->setCellValue('Q'.$row, number_format($report->tien_phai_thu))

                ->setCellValue('R'.$row, number_format($report->salary))
                ->setCellValue('S'.$row, number_format($report->award))
                ->setCellValue('T'.$row, $report->vc_name.' | '.$report->vc_phone.' | '.$report->vc_code)
                ->setCellValue('U'.$row, isset($report->vc_user)? $report->vc_user->name : '')
                ->setCellValue('V'.$row, config('system.order_status.'.$report->status));

            $row++;
        }


        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        $path = 'reports_'.date('Y_m_d_His').'.xlsx';

        $objWriter->save(storage_path('app/public/' . $path));

        return redirect('/storage/' . $path);
    }



}
