<?php

namespace App\Observers;

use App\Models\Customer;

class CustomerObserver
{
    /**
     * Handle the customer "created" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function created(Customer $customer)
    {
        $customer->code = 'CUS-'.$customer->id;
        //$customer->slug = str_slug($customer->name);
        $customer->save();
    }

    /**
     * Handle the customer "updated" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function updated(Customer $customer)
    {
        //
    }

    /**
     * Handle the customer "deleted" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function deleted(Customer $customer)
    {
        //
    }

    /**
     * Handle the customer "restored" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function restored(Customer $customer)
    {
        //
    }

    /**
     * Handle the customer "force deleted" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function forceDeleted(Customer $customer)
    {
        //
    }
}
