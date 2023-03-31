@extends('layouts.app')

@section('title') Index @endsection

@section('content')
    <div class="text-center">
        <button type="button" class="mt-4 btn btn-success"><a href="{{route('areas.create')}}" style="color:white;text-decoration:none;">Create Post</a></button>
    </div>
    <table id="mytable" class="table mt-4">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Address</th>
            <th scope="col">Created At</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>

        @foreach($areas as $area)
            <tr>
                <td>{{$area->id}}</td>
                <td>{{$area->name}}</td>
                <td>{{$area->address}}</td>
                <td>{{$area->created_at}}</td>
                
                <td>
                    <a href="{{route('areas.show', $area->id)}}" class="btn btn-info">View</a>
                    <a href="{{route("areas.edit", $area->id)}}" class="btn btn-primary">Edit</a>
                    <form style="display: inline" method="POST" action="{{ route('areas.destroy', $area->id) }}">
                        @method('DELETE')
                        @csrf
                        <button onclick="return confirm('Are you sure you want to delete this area?')" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
  
        @endforeach
        </tbody>
    </table>
    @endsection
 



   