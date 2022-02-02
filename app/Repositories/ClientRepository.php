<?php

namespace App\Repositories;

use App\Helpers\RequestHandler;
use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryContract;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientRepository implements ClientRepositoryContract
{
    public function getOne(int $id): Client
    {
        return Client::query()->find($id);
    }

    public function getMany(array $criterio): LengthAwarePaginator
    {
        return (new RequestHandler())->handleCriterions(Client::query(), $criterio);
    }
}
