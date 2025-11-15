<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::whereHas('user', function ($q) {
            $q->where('id', Auth::id());
        })->with('user')->paginate(10);
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
    public function store(Request $request)
    {
        $request->validate([
            'username'=> 'required|max:255',
            'email'=> 'required|email',
            'phone'=> 'required',
            'address'=> 'required|max:500',
            'note'=> 'nullable',
        ]);

        Client::create([
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'note' => $request->note,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('dashboard.clients.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::whereHas('user', function ($q) {
            $q->where('id', Auth::id());
        })->findOrFail($id);
        return view('dashboard.clients.details', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = Client::whereHas('user', function ($q) {
            $q->where('id', Auth::id());
        })->findOrFail($id);
        return view('dashboard.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'username'=> 'required|max:255',
            'email'=> 'required|email',
            'phone'=> 'required',
            'address'=> 'required|max:500',
            'note'=> 'nullable',
        ]);

        $client = Client::whereHas('user', function ($q) {
            $q->where('id', Auth::id());
        })->findOrFail($id);
        $client->update([
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'note' => $request->note,
        ]);

        return redirect()->route('dashboard.clients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::whereHas('user', function ($q) {
            $q->where('id', Auth::id());
        })->findOrFail($id);
        $client->delete();
        return redirect()->route('dashboard.clients.index');
    }
}
