@extends('layouts.app')

@section('title') Index @endsection

@section('content')
    <div class="text-center">
        <button type="button" class="mt-4 btn btn-success"><a href="{{route('medicines.create')}}" style="color:white;text-decoration:none;">Create Medicine</a></button>
    </div>
    <table id="mytable" class="table mt-4">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Type</th>
            <th scope="col">Price</th>
            <th scope="col">Created At</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>

        @foreach($medicines as $medicine)
            <tr>
                <td>{{$medicine->id}}</td>
                <td>{{$medicine->name}}</td>
                <td>{{$medicine->type}}</td>
                <td>{{$medicine->price}}</td>
                <td>{{$medicine->created_at}}</td>
                
                <td>
                    <a href="{{route('medicines.show', $medicine->id)}}" class="btn btn-info">View</a>
                    <a href="{{route("medicines.edit", $medicine->id)}}" class="btn btn-primary">Edit</a>
                    <form style="display: inline" method="POST" action="{{ route('medicines.destroy', $medicine->id) }}">
                        @method('DELETE')
                        @csrf
                        <button onclick="return confirm('Are you sure you want to delete this medicine?')" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
  
        @endforeach
        </tbody>
    </table>
    @endsection
 



   