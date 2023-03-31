<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        $clients=Client::all();
        return view('clients.index',['clients'=>$clients]);
    }

    public function show( $id)
    {
        // @dd($client);
       $client = Client::find($id);



        return view('clients.show', [
            "client" => $client
        ]);
    }

}
