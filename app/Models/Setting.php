<?php

namespace App\Models;

use DataTables;

class Setting extends \Eloquent
{

    protected $fillable = [
        'name',
        'value',
    ];

    public $timestamps = false;


    public static function getDataTables($request)
    {
        $setting = static::select('*');

        return DataTables::of($setting)
            ->filter(function ($query) use ($request) {
                if ($request->filled('name')) {
                    $query->where('name', 'like', '%' . $request->get('name') . '%');
                }
            })
            ->addColumn('action', function ($setting) {
                return '<a class="table-action-btn" title="Chỉnh sửa setting" href="' . route('settings.edit', $setting->id) . '"><i class="fa fa-pencil text-success"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
