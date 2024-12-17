<?php

namespace App\Observers;

use App\Models\orders;
use App\Models\OrdersObserved;

class OrdersObserver
{
    /**
     * Handle the orders "created" event.
     */
    public function created(orders $orders): void
    {
        //
        $change = new OrdersObserved();
        $change->order_id = $orders->order_id;
        $change->comision_id = $orders->comision_id;
        $change->user_id = $orders->order_createdBy;
        $change->order_date = $orders->order_date;
        $change->orderO_original = $orders->order_subject;
        //dd($change);
        $change->save();
    }

    /**
     * Handle the orders "updated" event.
     */
    public function updated(orders $orders): void
    {
        //
        $change = new OrdersObserved();
        $change->order_id = $orders->order_id;
        $change->comision_id = $orders->comision_id;
        $change->user_id = $orders->order_createdBy;
        $change->order_date = $orders->order_date;
        $change->orderO_original = strtolower($orders->order_subject);
        $change->save();
    }

    /**
     * Handle the orders "deleted" event.
     */
    public function deleted(orders $orders): void
    {
        //
    }

    /**
     * Handle the orders "restored" event.
     */
    public function restored(orders $orders): void
    {
        //
    }

    /**
     * Handle the orders "force deleted" event.
     */
    public function forceDeleted(orders $orders): void
    {
        //
    }
}
