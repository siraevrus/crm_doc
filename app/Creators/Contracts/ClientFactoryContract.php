<?php

namespace App\Creators\Contracts;

use App\Models\Client;

interface ClientFactoryContract
{
    public function createClient(array $data) : Client;
    public function updateClient(Client $client, array $data) : Client;
}
