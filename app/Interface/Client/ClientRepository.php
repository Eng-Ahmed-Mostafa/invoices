<?php

namespace App\Interface\Client;

use App\Http\Requests\Client\ClientRequest;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class ClientRepository implements ClientInterface
{
    public function getAllClients()
    {
        return Client::where('user_id', Auth::id())->get();
    }
    
    public function getAllPaginatedWithUser()
    {
        return Client::where('user_id', Auth::id())->with('user')->paginate(10);
    }

    public function createClient(ClientRequest $request)
    {
        return Client::create([
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'note' => $request->note,
            'user_id' => Auth::id()
        ]);
    }

    public function findClientById(int $id)
    {
        return Client::where('user_id',Auth::id())->findOrFail($id);
    }

    public function updateClient(ClientRequest $request, int $id)
    {
        $client = $this->findClientById($id);
        return $client->update([
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'note' => $request->note,
        ]);
    }

    public function deleteClient(int $id)
    {
        $client = $this->findClientById($id);
        return $client->delete();
    }
}
