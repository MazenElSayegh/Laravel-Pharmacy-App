@extends('layouts.sub')

@section('title') {{$pharmacy->type->name}} @endsection
@section('backtolink') <a href="{{route('pharmacies.index')}}" class="nav-link">All Pharmacies</a> @endsection

@section('content')
<div class="card">
  <div class="card-header bg-primary"></div>
  <div class="card-body">
    <p class="card-header"><img src="{{asset('/storage/' .$pharmacy->image_path)}}" class="img-fluid" width="50px">&nbsp; {{$pharmacy->type->name}}</p>
    <p class="card-text">EMAIL: {{$pharmacy->type->email}}</p>
    <p class="card-text">NATIONAL ID: {{$pharmacy->national_id}}</p>
    <p class="card-text">PRIORITY: {{$pharmacy->priority}}</p>
    <p class="card-text">AREA: {{$pharmacy->area->name}}</p>
    <p class="card-text">ADDRESS: {{$pharmacy->area->address}}</p>
</div>
</div>
</div>
   

@endsection