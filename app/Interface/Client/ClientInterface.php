<?php

namespace App\Interface\Client;

use App\Http\Requests\Client\ClientRequest;

interface ClientInterface
{
    public function getAllClients();
    public function getAllPaginatedWithUser();
    public function createClient(ClientRequest $request);
    public function findClientById(int $id);
    public function updateClient(ClientRequest $request, int $id);
    public function deleteClient(int $id);
}
