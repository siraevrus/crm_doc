<?php

namespace App\Http\Controllers;

use App\Http\Requests\Clients\CreateClientRequest;
use App\Http\Requests\Clients\ListClientRequest;
use App\Http\Requests\Clients\UpdateClientRequest;
use App\Http\Resources\Clients\ClientResource;
use App\Http\Resources\Clients\ClientResourceCollection;
use App\Models\Client;
use App\Services\Contracts\ClientServiceContract;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(private ClientServiceContract $serviceContract)
    {
    }

    public function index(ListClientRequest $request)
    {
        return new ClientResourceCollection(
            $this->serviceContract->getClientList($request->validated())
        );
    }

    public function get(Request $request, Client $client)
    {
        return new ClientResource($client);
    }

    public function create(CreateClientRequest $request)
    {
        return new ClientResource(
            $this->serviceContract->createClient($request->validated())
        );
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        return new ClientResource(
            $this->serviceContract->updateClient($client, $request->validated())
        );
    }

    public function delete(Request $request, Client $client)
    {
        $this->serviceContract->deleteClient($client);
    }
}
