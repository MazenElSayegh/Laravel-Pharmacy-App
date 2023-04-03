@extends('layouts.sub')

@section('title') {{$pharmacy->type->name}} @endsection
@section('backtolink') <a href="{{route('pharmacies.index')}}" class="nav-link">All Pharmacies</a> @endsection

@section('content')
<img src="{{asset('/storage/' .$pharmacy->image_path)}}" class="img-fluid w-25">
<div class="card">
  <div class="card-body">
    <p class="card-text">NAME: {{$pharmacy->type->name}}</p>
    <p class="card-text">EMAIL: {{$pharmacy->type->email}}</p>
    <p class="card-text">NATIONAL ID: {{$pharmacy->national_id}}</p>
    <p class="card-text">AREA ID: {{$pharmacy->area_id}}</p>
    <p class="card-text">PRIORITY: {{$pharmacy->priority}}</p>
</div>
</div>
</div>
   

@endsection