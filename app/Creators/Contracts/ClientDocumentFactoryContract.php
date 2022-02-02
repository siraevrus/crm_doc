<?php

namespace App\Creators\Contracts;

use App\Models\ClientDocument;

interface ClientDocumentFactoryContract
{
    public function createClientDocument(array $data) : ClientDocument;
    public function updateClientDocument(ClientDocument $clientDocument, array $data) : ClientDocument;
}
