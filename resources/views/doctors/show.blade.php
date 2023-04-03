@extends('layouts.sub')

@section('title') {{$doctor->type->name}} @endsection
@section('backtolink') <a href="{{route('doctors.index')}}" class="nav-link">All Doctors</a> @endsection

@section('content')
<img src="{{asset('/storage/' .$doctor->image_path)}}" class="img-fluid w-25">
<div class="card">
  <div class="card-body">
    <p class="card-text">NAME: {{$doctor->type->name}}</p>
    <p class="card-text">EMAIL: {{$doctor->type->email}}</p>
    <p class="card-text">NATIONAL ID: {{$doctor->national_id}}</p>
    <p class="card-text">Is Banned: @if($doctor->is_banned==0)No
                                    @else Yes
                                    @endif
    </p>

@endsection