<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientRequest;
use App\Interface\Client\ClientInterface;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    protected ClientInterface $clientRepository;

    public function __construct(ClientInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = $this->clientRepository->getAllPaginatedWithUser();
        return view('dashboard.clients.index' ,compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        $request->validated();

        $this->clientRepository->createClient($request);

        return redirect()->route('dashboard.clients.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = $this->clientRepository->findClientById($id);
        $invoices = Invoice::where('client_id',$client->id)->get();
        return view('dashboard.clients.details', compact('client','invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = $this->clientRepository->findClientById($id);
        return view('dashboard.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, string $id)
    {
        $request->validated();

        $this->clientRepository->updateClient($request, $id);

        return redirect()->route('dashboard.clients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->clientRepository->deleteClient($id);
        return redirect()->route('dashboard.clients.index');
    }
}
