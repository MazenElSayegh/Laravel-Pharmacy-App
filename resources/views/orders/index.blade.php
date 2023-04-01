@extends('layouts.app')

@section('title') Index @endsection

@section('content')
    <div class="text-center">
        <button type="button" class="mt-4 btn btn-success"><a href="{{route('orders.create')}}" style="color:white;text-decoration:none;">Create Order</a></button>
    </div>
    <table id="mytable" class="table mt-4">
        <thead>
        <tr>
            <th scope="col">Order ID</th>
            <th scope="col">Ordered User Name</th>
            <th scope="col">Delivering Address</th>
            <th scope="col">Doctor Name</th>
            <th scope="col">Is Insured</th>
            <th scope="col">Status</th>
            <th scope="col">Created At</th>
            <th scope="col">Actions</th>
            
        </tr>
        </thead>
        <tbody>

        {{-- @foreach($pharmacies as $pharmacy)
            <tr>
                <td>{{$pharmacy->name}}</td>
                <td>{{$pharmacy->email}}</td>
                <td>{{$pharmacy->national_id}}</td>
                @if($pharmacy->image_path)
                <td>{{$pharmacy->image_path}}</td>
                @else
                <td>Not Found</td>
                @endif
                <td>{{$pharmacy->priority}}</td>
                
                <td>
                    <a class="btn btn-info">View</a>
                    <a class="btn btn-primary" >Edit</a>
                    <form style="display: inline" method="POST">
                    @method('DELETE')
                    @csrf
                    <button onclick="return confirm('Are you sure you want to delete this post?');" class="btn btn-danger">Delete</button>
                </form>
                </td>
            </tr>
  
        @endforeach --}}
        </tbody>
    </table>
    @endsection
 



   