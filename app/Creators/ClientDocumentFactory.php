<?php

namespace App\Creators;

use App\Creators\Contracts\ClientDocumentFactoryContract;
use App\Models\ClientDocument;
use Illuminate\Support\Facades\Storage;

class ClientDocumentFactory implements ClientDocumentFactoryContract
{
    public function createClientDocument(array $data): ClientDocument
    {
        $clientDocument = new ClientDocument();
        $clientDocument->fill(array_merge($data, [
            'file' => Storage::putFile('/clients/documents/', $data['document'])
        ]));
        $clientDocument->save();

        return $clientDocument;
    }

    public function updateClientDocument(ClientDocument $clientDocument, array $data): ClientDocument
    {
        $clientDocument->fill(array_merge($data, [
            'file' => Storage::putFile('/clients/documents/', $data['document']),
        ]));
        $clientDocument->save();

        return $clientDocument;
    }
}
