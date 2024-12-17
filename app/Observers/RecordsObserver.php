<?php

namespace App\Observers;

use App\Models\records;
use App\Models\RecordsObserved;
use Carbon\Carbon;

class RecordsObserver
{
    /**
     * Handle the records "created" event.
     */
    public function created(records $records): void
    {
        //
        $change = new RecordsObserved();
        $change->user_id = $records->user_id;
        $change->position_id = $records->position_id;
        $change->comision_id = $records->comision_id;
        $change->recordO_original = 'Se creó el registro con el usuario: ' . strtolower($records->RUserRecords->name) . ', posición del usuario: ' . $records->RPosRecords->position . ' y comisión: ' . $records->RComRecords->comision_name;
        $change->save();
    }

    public function updated(records $records): void
    {
        //
        $change = new RecordsObserved();
        $change->user_id = $records->user_id;
        $change->position_id = $records->position_id;
        $change->comision_id = $records->comision_id;
        $cadena = "";
        if ($records->isDirty('position_id')) {
            switch ($records->getOriginal('position_id')) {
                case '1':
                    $change->recordO_original = 'La posición original era: Presidente';
                    break;
                case '2':
                    $change->recordO_original = 'La posición original era: Secretario';
                    break;
                case '3':
                    $change->recordO_original = 'La posición original era: Vocal';
                    break;
                case '4':
                    $change->recordO_original = 'La posición original era: Integrante';
                    break;

                default:
                    $change->recordO_original = 'La posición original era: ' . $records->getOriginal('position_id');
                    break;
            }
            $change->recordO_movement = 'La posición nueva es: ' . $records->RPosRecords->position;
            $cadena = 1;
            //dd($change);
        }
        if ($records->isDirty('record_status')) {
            if ($records->getOriginal('record_status') == 1) {
                $change->recordO_disenable = 'El registro se desactivó el: ' . Carbon::now();
            } else {
                $change->recordO_disenable = 'El registro se reactivó el: ' . Carbon::now();
            }
            $cadena = 1;
        }
        if ($cadena != "") {
            $change->save();
        }
    }

    // /**
    //  * Handle the records "updated" event.
    //  */
    // public function updated(records $records): void
    // {
    //     //
    // }

    // /**
    //  * Handle the records "deleted" event.
    //  */
    // public function deleted(records $records): void
    // {
    //     //
    // }

    // /**
    //  * Handle the records "restored" event.
    //  */
    // public function restored(records $records): void
    // {
    //     //
    // }

    // /**
    //  * Handle the records "force deleted" event.
    //  */
    // public function forceDeleted(records $records): void
    // {
    //     //
    // }
}
