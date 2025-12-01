<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clients;

class ClientController extends Controller
{
    public function addclient(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Save client
        $clients = new Clients();
        $clients->user_id = auth()->id(); // Associate with current user
        $clients->name = $request->name;
        $clients->company = $request->company;
        $clients->email = $request->email;
        $clients->phone = $request->phone;
        $clients->address = $request->address;
        $clients->notes = $request->notes;

        $clients->save();

        return redirect()->back()->with('success', 'Client added successfully!');
    }

    public function clientlist()
    {
        $userId = auth()->id();
        $clients = Clients::where('user_id', $userId)->get();
        return view('clientlist', compact('clients'));
    }

    public function updateclient($id)
    {
        $userId = auth()->id();
        $clients = Clients::where('id', $id)->where('user_id', $userId)->firstOrFail();
        return view('updateclient', compact('clients'));
    }

    public function postupdateclient(Request $request, $id)
    {
        $userId = auth()->id();
        $clients = Clients::where('id', $id)->where('user_id', $userId)->firstOrFail();

        $clients->name = $request->name;
        $clients->company = $request->company;
        $clients->email = $request->email;
        $clients->phone = $request->phone;
        $clients->address = $request->address;
        $clients->notes = $request->notes;

        $clients->save();

        return redirect('/clientlist')->with('success', 'Client updated successfully!');
    }

    public function deleteclient($id)
    {
        $userId = auth()->id();
        $clients = Clients::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $clients->delete();

        return redirect()->back()->with('success', 'Client deleted successfully!');
    }
}
