@extends('layouts.app')

@section('title')Addresses Index @endsection

@section('content')
    <div class="text-center">
        <button type="button" class="mt-4 btn btn-success"><a href="{{route('addresses.create')}}" style="color:white;text-decoration:none;">Create Client Address</a></button>
    </div>
    <table id="mytable" class="table mt-4">
        <thead>
        <tr>
            <th scope="col">Area ID</th>
            <th scope="col">Street Name</th>
            <th scope="col">Building Number</th>
            <th scope="col">Floor Number</th>
            <th scope="col">Flat Number</th>
            <th scope="col">is main</th>
            <th scope="col">Client ID</th>
            <th scope="col">Actions</th>
            
        </tr>
        </thead>
        <tbody>

        @foreach($addresses as $address)
            <tr>
                <td>{{$address->area_id}}</td>
                <td>{{$address->street_name}}</td>
                <td>{{$address->build_no}}</td>
                <td>{{$address->floor_no}}</td>
                <td>{{$address->flat_no}}</td>
                <td>{{$address->is_main}}</td>
                <td>{{$address->client_id}}</td>
                
               
                
                <td>
                    <a  href="{{route('addresses.show', $address['id'])}}" class="btn btn-info">View</a>
                    <a href="{{route("addresses.edit",$address["id"]),"/edit"}}" class="btn btn-primary" >Edit</a>
                    <form action="{{route('addresses.destroy',$address->id)}}" style="display: inline" method="POST">
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
 



   