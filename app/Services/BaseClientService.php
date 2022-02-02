<?php

namespace App\Services;

use App\Creators\Contracts\ClientDocumentFactoryContract;
use App\Creators\Contracts\ClientFactoryContract;
use App\Models\Client;
use App\Models\ClientDocument;
use App\Repositories\Contracts\ClientRepositoryContract;
use App\Services\Contracts\ClientServiceContract;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class BaseClientService implements ClientServiceContract
{
    public function __construct(private ClientRepositoryContract $repositoryContract, private ClientFactoryContract $factory, private ClientDocumentFactoryContract $documentFactory)
    {

    }

    public function getOne(int $id) : Client
    {
        return $this->repositoryContract->getOne($id);
    }

    public function getClientList(array $data) : LengthAwarePaginator
    {
        return $this->repositoryContract->getMany($data);
    }

    public function createClient(array $data): Client
    {
        return $this->factory->createClient($data);
    }

    public function updateClient(Client $client, array $data): Client
    {
        return $this->factory->updateClient($client, $data);
    }

    public function deleteClient(Client $client)
    {
        $client->delete();
    }

    public function addDocument(array $data): ClientDocument
    {
        return $this->documentFactory->createClientDocument($data);
    }

    public function deleteDocument(ClientDocument $clientDocument)
    {
        Storage::delete($clientDocument->path);
        $clientDocument->delete();
    }

    public function updateDocument(ClientDocument $clientDocument, array $data)
    {
        Storage::delete($clientDocument->file);
        return $this->documentFactory->updateClientDocument($clientDocument, $data);
    }
}
