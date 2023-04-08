@extends('layouts.sub')

@section('title') {{$doctor->type->name}} @endsection
@section('backtolink') <a href="{{route('doctors.index')}}" class="nav-link">All Doctors</a> @endsection

@section('content')
<div class="card">
  <div class="card-header bg-primary"></div>
  <div class="card-body">
    <p class="card-header"><img src="{{asset('/storage/' .$doctor->image_path)}}" class="img-fluid" width="50px">&nbsp; {{$doctor->type->name}}</p>
    <p class="card-text">EMAIL: {{$doctor->type->email}}</p>
    <p class="card-text">NATIONAL ID: {{$doctor->national_id}}</p>
    <p class="card-text">Is Banned: @if($doctor->is_banned==0)No
                                    @else Yes
                                    @endif
    </p>
    <p class="card-text">Created at: {{$doctor->created_at->format("Y/m/d")}}</p>
    @role('admin')
    <p class="card-text">Pharmacy: {{$doctor->pharmacy->type->name}}</p>
    @endrole

@endsection