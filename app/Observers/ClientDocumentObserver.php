<?php

namespace App\Observers;

use App\Models\ClientDocument;
use Illuminate\Support\Facades\Storage;

class ClientDocumentObserver
{
    /**
     * Handle the ClientDocument "created" event.
     *
     * @param  \App\Models\ClientDocument  $clientDocument
     * @return void
     */
    public function created(ClientDocument $clientDocument)
    {
        //
    }

    /**
     * Handle the ClientDocument "updated" event.
     *
     * @param  \App\Models\ClientDocument  $clientDocument
     * @return void
     */
    public function updated(ClientDocument $clientDocument)
    {
        //
    }

    /**
     * Handle the ClientDocument "deleted" event.
     *
     * @param  \App\Models\ClientDocument  $clientDocument
     * @return void
     */
    public function deleted(ClientDocument $clientDocument)
    {
        Storage::delete($clientDocument->file);
    }

    /**
     * Handle the ClientDocument "restored" event.
     *
     * @param  \App\Models\ClientDocument  $clientDocument
     * @return void
     */
    public function restored(ClientDocument $clientDocument)
    {
        //
    }

    /**
     * Handle the ClientDocument "force deleted" event.
     *
     * @param  \App\Models\ClientDocument  $clientDocument
     * @return void
     */
    public function forceDeleted(ClientDocument $clientDocument)
    {
        //
    }
}
