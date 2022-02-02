<?php

namespace App\Repositories\Contracts;

use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;

interface ClientRepositoryContract
{
    public function getOne(int $id) : Client;
    public function getMany(array $criterio) : LengthAwarePaginator;
}
