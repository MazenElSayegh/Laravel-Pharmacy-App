@extends('layouts.app')

@section('title') Index @endsection

@section('content')
<img src="{{asset('/storage/' . $pharmacy->image_path)}}" class="img-fluid" alt="Responsive image">
<div class="card">
  <div class="card-body">
    <p class="card-text">NAME: {{$pharmacy->name}}</p>
    <p class="card-text">EMAIL: {{$pharmacy->email}}</p>
    <p class="card-text">NATIONAL ID: {{$pharmacy->national_id}}</p>
</div>
</div>
   

@endsection