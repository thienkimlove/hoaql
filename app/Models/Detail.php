<?php

namespace App\Models;

use DataTables;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{

    protected $fillable = [
        'order_id',
        'is_manually',
        'start_code',
        'end_code',
        'manually_items',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public static function getDataTables($request)
    {

        $user = \Sentinel::getUser();

        $content = static::select('*');

        $order = null;

        if ($request->filled('order_id')) {
            $order = Order::find($request->get('order_id'));
        }


        return DataTables::of($content)
            ->filter(function ($query) use ($request) {
                if ($request->filled('order_id')) {
                    $query->where('order_id', 'like', $request->get('order_id'));
                }
            })
            ->addColumn('action', function ($content) use ($user) {
                $response = null;

                if ($content->order->canEditTransportInfo() && $user->hasAccess(['transports'])) {
                    $response .= '<a class="table-action-btn" id="btn-delete-' . $content->id . '" title="Xóa thông tin mã" data-url="' . route('details.delete', $content->id) . '" href="javascript:;"><i class="fa fa-remove text-danger"></i></a>';
                }

                return $response;

            })
            ->editColumn('is_manually', function($content){
                return config('system.item_list.'.$content->is_manually);
            })
            ->addColumn('info', function($content) {
                $response = null;

                if ($content->is_manually) {
                    $products = $content->products ?  implode(',', $content->products->pluck('code')->all()) : '';
                    $response.= '<b>Mã lẻ</b> '.$products;
                } else {
                    $response.= '<b>Từ mã</b> '.$content->start_code.'<br/>';
                    $response.= '<b>Đến mã</b> '.$content->end_code;
                }

                return $response;
            })
            ->editColumn('created_at', function($content){
                return $content->created_at->format('d/m/Y');
            })
            ->addColumn('already_insert', function($content) use ($order) {
                $already_insert = 0;
                if ($order) {
                    $already_insert = $order->products->count();
                }
                return $already_insert;
            })

            ->addColumn('still_needed', function($content) use ($order) {
                $still_needed = 0;
                if ($order) {
                    $already_insert = $order->products->count();
                    $still_needed = $order->quantity - $already_insert;
                }
                return $still_needed;
            })

            ->rawColumns(['action', 'info'])
            ->make(true);
    }



}
