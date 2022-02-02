<?php

namespace App\Creators;

use App\Creators\Contracts\ClientFactoryContract;
use App\Models\Client;

class ClientFactory implements ClientFactoryContract
{
    public function createClient(array $data): Client
    {
        $client = new Client();
        $client->fill($data);
        $client->save();

        $this->attachDocuments($client, $data);

        return $client;
    }

    public function updateClient(Client $client, array $data): Client
    {
        $client->fill($data);
        $client->save();

        $this->attachDocuments($client, $data);

        return $client;
    }

    public function attachDocuments(Client $client, array $data)
    {
        if(isset($data['documents']) && count($data['documents'])) {
            $data['documents'] = array_map(function($el) use ($client) {
                $el['client_id'] = $client->id;
                return $el;
            }, $data['documents']);

            $client->documents()->upsert($data['documents'], ['id'], ['client_id', 'name', 'signed', 'type']);
        }
    }
}
