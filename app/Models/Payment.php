<?php

namespace App\Models;

use DataTables;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $fillable = [
        'name',
        'status',
    ];


    public static function getDataTables($request)
    {

        $user = \Sentinel::getUser();

        $content = static::select('*');

        return DataTables::of($content)
            ->filter(function ($query) use ($request) {
                if ($request->filled('name')) {
                    $query->where('name', 'like', '%' . $request->get('name') . '%');
                }

                if ($request->filled('status')) {
                    $query->where('status', $request->get('status'));
                }
            })
            ->addColumn('action', function ($content) use ($user) {

                $response = null;

                if ($user->hasAccess(['payments'])) {
                    $response .= '<a class="table-action-btn" title="Chỉnh sửa" href="' . route('payments.edit', $content->id) . '"><i class="fa fa-pencil text-success"></i></a>';
                }

                return $response;

            })

            ->addColumn('histories', function ($content) {
                $histories = '';

                $logs = Event::where('content', 'payments')
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
                return $content->status ? '<i class="ion ion-checkmark-circled text-success"></i>' : '<i class="ion ion-close-circled text-danger"></i>';
            })
            ->rawColumns(['action', 'status', 'histories'])
            ->make(true);
    }



}
