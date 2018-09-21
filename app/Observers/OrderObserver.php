<?php

namespace App\Observers;

use App\Models\Customer;
use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the customer "created" event.
     *
     * @param Order $order
     * @return void
     */
    public function created(Order $order)
    {
        $order->code = 'DL-'.$order->id;
        //$customer->slug = str_slug($customer->name);
        $order->save();
    }

    /**
     * Handle the customer "updated" event.
     *
     * @param Order $order
     * @return void
     */
    public function updated(Order $order)
    {
        //
    }

    /**
     * Handle the customer "deleted" event.
     *
     * @param Order $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the customer "restored" event.
     *
     * @param Order $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the customer "force deleted" event.
     *
     * @param Order $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
