<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use DataTables;

class Customer extends \Eloquent
{

    use Sluggable;
    use SluggableScopeHelpers;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true,
            ]
        ];
    }

    protected $fillable = [
        'name',
        'slug',
        'phone',
        'address',
        'parent_id',
        'district_id',
        'status',
    ];

    public function parent()
    {
        return $this->belongsTo(Customer::class, 'parent_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * sub of this customer
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Customer::class, 'parent_id', 'id');

    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->setCode();
        });
    }

    public function setCode()
    {
        $this->code = 'CUS-'.$this->id;
        return $this;
    }


    public static function getDataTables($request)
    {

        $user = \Sentinel::getUser();

        $customer = static::select('*')->with('parent');

        return DataTables::of($customer)
            ->filter(function ($query) use ($request) {
                if ($request->filled('name')) {
                    $query->where('name', 'like', '%' . $request->get('name') . '%');
                }

                if ($request->filled('status')) {
                    $query->where('status', $request->get('status'));
                }
            })
            ->addColumn('action', function ($customer) use ($user) {

                $response = null;

                if ($user->hasAccess(['customers'])) {
                    $response .= '<a class="table-action-btn" title="Chỉnh sửa đại lý" href="' . route('customers.edit', $customer->id) . '"><i class="fa fa-pencil text-success"></i></a>';
                }

                return $response;

            })
            ->addColumn('parent_name', function ($customer) {
                return $customer->parent_id ? $customer->parent->name : '';
            })
            ->addColumn('district_name', function ($customer) {
                return $customer->district ? $customer->district->name.' - '. $customer->district->province->name : '';
            })
            ->addColumn('histories', function ($post) {
                $histories = '';

                $logs = Event::where('content', 'customers')
                    ->where('content_id', $post->id)
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
            ->editColumn('created_at', function($customer){
                return $customer->created_at->format('d/m/Y');
            })
            ->editColumn('status', function ($customer) {
                return $customer->status ? '<i class="ion ion-checkmark-circled text-success"></i>' : '<i class="ion ion-close-circled text-danger"></i>';
            })
            ->rawColumns(['action', 'status', 'histories'])
            ->make(true);
    }


}
