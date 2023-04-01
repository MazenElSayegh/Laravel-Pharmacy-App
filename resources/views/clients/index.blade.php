@extends('layouts.app')

@section('title')Clients Index @endsection

@section('content')
    <div class="text-center">
        <button type="button" class="mt-4 btn btn-success"><a href="{{route('clients.create')}}" style="color:white;text-decoration:none;">Create client</a></button>
    </div>
    <table id="mytable" class="table mt-4">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">National ID</th>
            <th scope="col">Gender</th>
            <th scope="col">Birth Day</th>
            <th scope="col">Image</th>
            <th scope="col">Actions</th>
            
        </tr>
        </thead>
        <tbody>

        @foreach($clients as $client)
            <tr>
                <td>{{$client->name}}</td>
                <td>{{$client->email}}</td>
                <td>{{$client->national_id}}</td>
                <td>{{$client->gender}}</td>
                <td>{{$client->birth_day}}</td>
                @if($client->avatar)
                <td>{{$client->avatar}}</td>
                @else
                <td>Not Found</td>
                @endif
               
                
                <td>
                    <a  href="{{route('clients.show', $client['id'])}}" class="btn btn-info">View</a>
                    <a class="btn btn-primary" href="{{route("clients.edit",$client["id"]),"/edit"}}">Edit</a>
                    <form action="{{route('clients.destroy',$client->id)}}"  style="display: inline" method="POST">
                    @method('DELETE')
                    @csrf
                    <button onclick="return confirm('Are you sure you want to delete this post?');" class="btn btn-danger">Delete</button>
                </form>
                </td>
            </tr>
  
        @endforeach
        </tbody>
    </table>
    @endsection
 



   