<?php

namespace App\Http\Controllers;
use App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Models\Clients;

class ClientController extends Controller
{
    public function addclient(Request $request)
    {
        $clients = new clients();
        $clients->user_id = auth()->id(); 
        $clients->name=$request->name;
        $clients->company=$request->company;
        $clients->email=$request->email;
        $clients->phone=$request->phone;
        $clients->address=$request->address;
        $clients->notes=$request->notes;

        $clients->save();
        return redirect()->back();
    }

    public function clientlist()
    {
        $clients = Clients::all();
        return view('clientlist',compact('clients'));
    }

    public function updateclient($id)
    {
        $clients = Clients::findOrFail($id);
        return view('updateclient',compact('clients'));
    }
    public function postupdateclient(Request $request, $id)
    {
        $clients = Clients::findOrFail($id);
        $clients->name=$request->id;
        $clients->company=$request->company;
        $clients->email=$request->email;
        $clients->phone=$request->phone;
        $clients->address=$request->address;
        $clients->notes=$request->notes;
        $clients->save();
        return redirect('/clientlist');
    }



    public function deleteclient($id)
    {
        $clients = Clients::findOrFail($id);
        $clients->delete();
        return redirect()->back();
    }
}
