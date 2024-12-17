<?php

namespace App\Observers;

use App\Models\ComisionObserved;
use App\Models\comisions;
use Carbon\Carbon;

class ComisionsObserver
{
    /**
     * Handle the comisions "created" event.
     */
    public function created(comisions $comisions): void
    {
        //
        $change = new ComisionObserved;
        $change->observed_original = 'Se creó la comisión con el nombre: ' . strtolower($comisions->comision_name) ;
        $change->observed_comisionId = $comisions->comision_id;
        $change->save();
    }

    /**
     * Handle the comisions "updated" event.
     */
    public function updated(comisions $comisions): void
    {
        //
    }

    public function updating(comisions $comisions): void
    {
        //
        $change = new ComisionObserved;
        $change->observed_movement = '';
        $change->observed_comisionId = $comisions->comision_id;
        if ($comisions->isDirty('comision_name')) {
            $change->observed_movement = 'El nombre original era: ' . $comisions->getOriginal('comision_name') . ' y el nuevo nombre es: ' . strtolower($comisions->comision_name) ;
            $change->save();
        }
        if ($comisions->isDirty('comision_status')) {
            if ($comisions->getOriginal('comision_status') == 1) {
                $change->observed_movement = 'La comisión se desactivó el: ' . Carbon::now();
            } else {
                $change->observed_movement = 'La comisión se reactivó el: ' . Carbon::now();
            }
            $change->save();
        }
    }

    // /**
    //  * Handle the comisions "deleted" event.
    //  */
    // public function deleted(comisions $comisions): void
    // {
    //     //
    // }

    // /**
    //  * Handle the comisions "restored" event.
    //  */
    // public function restored(comisions $comisions): void
    // {
    //     //
    // }

    // /**
    //  * Handle the comisions "force deleted" event.
    //  */
    // public function forceDeleted(comisions $comisions): void
    // {
    //     //
    // }
}
