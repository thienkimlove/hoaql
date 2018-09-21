<?php

namespace App\Models;

use App\Lib\Helpers;
use DataTables;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{

    protected $fillable = [
        'name',
        'quantity',
        'price',
        'salary',
        'award',
        'status',
    ];


    public static function getDataTables($request)
    {

        $user = \Sentinel::getUser();

        $rule = static::select('*');

        return DataTables::of($rule)
            ->filter(function ($query) use ($request) {
                if ($request->filled('name')) {
                    $query->where('name', 'like', '%' . $request->get('name') . '%');
                }

                if ($request->filled('status')) {
                    $query->where('status', $request->get('status'));
                }
            })
            ->addColumn('action', function ($rule) use ($user) {

                $response = null;

                if ($user->hasAccess(['rules'])) {
                    $response .= '<a class="table-action-btn" title="Chỉnh sửa cơ chế" href="' . route('rules.edit', $rule->id) . '"><i class="fa fa-pencil text-success"></i></a>';
                }

                return $response;

            })
            ->editColumn('quantity', function($rule){
                return Helpers::vn_price($rule->quantity, true);
            })

            ->editColumn('price', function($rule){
                return Helpers::vn_price($rule->price);
            })

            ->editColumn('salary', function($rule){
                return Helpers::vn_price($rule->salary);
            })

            ->editColumn('award', function($rule){
                return Helpers::vn_price($rule->award);
            })

            ->addColumn('histories', function ($rule) {
                $histories = '';

                $logs = Event::where('content', 'customers')
                    ->where('content_id', $rule->id)
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
            ->editColumn('created_at', function($rule){
                return $rule->created_at->format('d/m/Y');
            })

            ->editColumn('status', function ($rule) {
                return $rule->status ? '<i class="ion ion-checkmark-circled text-success"></i>' : '<i class="ion ion-close-circled text-danger"></i>';
            })
            ->rawColumns(['action', 'status', 'histories'])
            ->make(true);
    }


}
