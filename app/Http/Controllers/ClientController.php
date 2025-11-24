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
        'email' => 'required|email|unique:clients,email',  // Email must be unique
        'company' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:50',
        'address' => 'nullable|string',
        'notes' => 'nullable|string',
    ]);

    // Save client
    $clients = new Clients();
    $clients->user_id = auth()->id();
    $clients->name = $request->name;
    $clients->company = $request->company;
    $clients->email = $request->email;
    $clients->phone = $request->phone;
    $clients->address = $request->address;
    $clients->notes = $request->notes;

    $clients->save();

    // Success message
    return redirect()->back()->with('success', 'Client added successfully!');
}


    public function clientlist()
    {
        $clients = Clients::all();
        return view('clientlist', compact('clients'));
    }

    public function updateclient($id)
    {
        $clients = Clients::findOrFail($id);
        return view('updateclient', compact('clients'));
    }

    public function postupdateclient(Request $request, $id)
    {
        $clients = Clients::findOrFail($id);
        $clients->name = $request->name;
        $clients->company = $request->company;
        $clients->email = $request->email;
        $clients->phone = $request->phone;
        $clients->address = $request->address;
        $clients->notes = $request->notes;

        $clients->save();

        return redirect('/clientlist');
    }

    public function deleteclient($id)
    {
        $clients = Clients::findOrFail($id);
        $clients->delete();
        return redirect()->back()->with('success', 'Client deleted successfully!');
    }
}
