<?php

namespace App\Services\Contracts;

use App\Models\Client;
use App\Models\ClientDocument;
use Illuminate\Pagination\LengthAwarePaginator;

interface ClientServiceContract
{
    public function getOne(int $id) : Client;
    public function getClientList(array $data) : LengthAwarePaginator;
    public function createClient(array $data) : Client;
    public function updateClient(Client $client, array $data) : Client;
    public function deleteClient(Client $client);
    public function addDocument(array $data) : ClientDocument;
    public function updateDocument(ClientDocument $clientDocument, array $data);
    public function deleteDocument(ClientDocument $clientDocument);
}
