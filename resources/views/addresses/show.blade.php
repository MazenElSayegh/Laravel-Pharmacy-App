@extends('layouts.sub')
@section('title') Area #{{$address->id}} @endsection
@section('backtolink') <a href="{{route('addresses.index')}}" class="nav-link">All Addresses</a> @endsection
@section('content')


<div class="card">
  <div class="card-body">
    
    <p class="card-text">Area ID: {{$address->area_id}}</p>
    <p class="card-text">Street Name: {{$address->street_name}}</p>
    <p class="card-text">Building Number: {{$address->build_no}}</p>
    <p class="card-text">Floor Number: {{$address->floor_no}}</p>
    <p class="card-text">Flat Number: {{$address->flat_no}}</p>
    <p class="card-text">Main:{{$address->is_main}}</p>
    <p class="card-text">Client ID: {{$address->client_id}}</p>

  </div>
</div>

@endsection