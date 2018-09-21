<?php

namespace App\Models;


use App\Lib\Helpers;
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
        return ($this->isPackage() || $this->isDelivery());
    }

    public function canDelivery()
    {
        return $this->isPackage();
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
        return ($this->isCreate() || $this->isPackage());
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
            })
            ->addColumn('action', function ($content) use ($user) {

                $response = null;

                if (($content->canEditSaleInfo() && $user->hasAccess(['orders'])) || ($content->canEditTransportInfo() && $user->hasAccess(['transports']))) {
                    $response .= '<a class="table-action-btn" title="Cập nhật đơn" href="' . route('orders.edit', $content->id) . '"><i class="fa fa-pencil text-success"></i></a>';
                }

                if ($content->canComplete() && $user->hasAccess(['orders'])) {
                    $response .= '<a class="table-action-btn" id="btn-complete-' . $content->id . '" title="Hoàn thành đơn" data-url="' . route('orders.complete', $content->id) . '" href="javascript:;"><i class="fa fa-check text-success"></i></a>';
                }

                if ($content->canDelivery() && $user->hasAccess(['transports'])) {
                    $response .= '<a class="table-action-btn" id="btn-delivery-' . $content->id . '" title="Đánh dấu đơn đã chuyển" data-url="' . route('orders.delivery', $content->id) . '" href="javascript:;"><i class="fa fa-subway text-warning"></i></a>';
                }

                if ($content->canCancel() && $user->hasAccess(['orders'])) {
                    $response .= '<a class="table-action-btn" id="btn-cancel-' . $content->id . '" title="Hủy đơn" data-url="' . route('orders.cancel', $content->id) . '" href="javascript:;"><i class="fa fa-remove text-danger"></i></a>';
                }

                if ($content->canReturn() && $user->hasAccess(['orders'])) {
                    $response .= '<a class="table-action-btn" id="btn-return-' . $content->id . '" title="Hoàn đơn" data-url="' . route('orders.return', $content->id) . '" href="javascript:;"><i class="fa fa-backward text-danger"></i></a>';
                }

                return $response;

            })
            ->addColumn('customer', function($content){
                return '<p><b>Tên : </b>'.$content->customer_name.'<br/><b>SDT : </b>'.$content->customer_phone.'<br/><b>Địa chỉ : </b>'.$content->customer_address.'<br/></p>';
            })

            ->addColumn('order', function($content){
                return '<p><b>Số lượng : </b>'.Helpers::vn_price($content->quantity, true).'<br/><b>Đơn giá : </b>'.Helpers::vn_price($content->price).'<br/><b>Lương : </b>'.Helpers::vn_price($content->salary).'<br/><b>Thưởng : </b>'.Helpers::vn_price($content->award).'<br/><b>Số túi : </b>'.Helpers::vn_price($content->bag_qty, true).'<br/><b>Số hộp : </b>'.Helpers::vn_price($content->box_qty, true).'<br/><b>Khuyến mãi : </b>'.Helpers::vn_price($content->gift, true).'<br/></p>';
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
            ->rawColumns(['action', 'status', 'histories', 'customer', 'order', 'transport'])
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

        $reports = $query->get();

        return (new static())->createExcelFile($reports);
    }

    public function createExcelFile($reports)
    {
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load(resource_path('templates/orders.xlsx'));

        $row = 2;
        foreach ($reports as $report) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $row - 1)
                ->setCellValue('B'.$row, $report->code)
                ->setCellValue('C'.$row, $report->customer_name)
                ->setCellValue('D'.$row, $report->customer_phone)
                ->setCellValue('E'.$row, $report->customer_address)
                ->setCellValue('F'.$row, Helpers::intToDotString($report->quantity))
                ->setCellValue('G'.$row, Helpers::vn_price($report->salary))
                ->setCellValue('H'.$row, Helpers::vn_price($report->salary))
                ->setCellValue('I'.$row, Helpers::vn_price($report->award))
                ->setCellValue('J'.$row, Helpers::intToDotString($report->bag_qty))
                ->setCellValue('K'.$row, Helpers::intToDotString($report->box_qty))
                ->setCellValue('L'.$row, $report->created_at->format('d/m/Y'))
                ->setCellValue('M'.$row, $report->sale_user->name)
                ->setCellValue('N'.$row, Helpers::vn_price($report->total))
                ->setCellValue('O'.$row, Helpers::vn_price($report->phi_vc_thu_ho))
                ->setCellValue('P'.$row, Helpers::vn_price($report->phi_vc_cty_tra))
                ->setCellValue('Q'.$row, Helpers::vn_price($report->tien_phai_thu))
                ->setCellValue('R'.$row, $report->vc_name)
                ->setCellValue('S'.$row, $report->vc_phone)
                ->setCellValue('T'.$row, $report->vc_code)
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
