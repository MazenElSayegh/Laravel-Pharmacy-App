@extends('layouts.app')

@section('title') Doctors Index @endsection

@section('content')
    <div class="text-center">
        <button type="button" class="mt-4 btn btn-success"><a href="{{route('doctors.create')}}" style="color:white;text-decoration:none;">Create Doctor</a></button>
    </div>
    <table id="mytable" class="table mt-4">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">National ID</th>
            <th scope="col">Image</th>
            <th scope="col">Is Banned</th>
            <th scope="col">Created At</th>
            <th scope="col">Actions</th>
            {{-- @if($user->hasRole('admin')){
                <th scope="col">Pharmacy Id</th> 
            } 
            @endif --}}
        </tr>
        </thead>
        <tbody>

        @foreach($doctors as $doctor)
            <tr>
                <td>{{$doctor->name}}</td>
                <td>{{$doctor->email}}</td>
                <td>{{$doctor->national_id}}</td>
                @if($doctor->image_path)
                <td>{{$doctor->image_path}}</td>
                @else
                <td>Not Found</td>
                @endif
                @if($doctor->is_banned==0){
                        <td>No</td>
                    }
                @else{
                    <td>Yes</td>
                }
                @endif
                {{-- @if($user->hasRole('admin')){
                    <td>{{$doctor->pharmacy_id}}</td>
                } 
                @endif --}}
                <td>{{$doctor->created_at}}</td>
                <td>
                    <a class="btn btn-info" href="{{route('doctors.show',$doctor->id)}}">View</a>
                    <a class="btn btn-primary" >Edit</a>
                    <form style="display: inline" method="POST">
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