@extends('layouts.app')

@section('title') Index @endsection

@section('content')

<div class="card">
  <div class="card-body">
    <p class="card-text">NAME: {{$doctor->name}}</p>
    <p class="card-text">EMAIL: {{$doctor->email}}</p>
    <p class="card-text">NATIONAL ID: {{$doctor->national_id}}</p>
    <p class="card-text">Is Banned: @if($doctor->is_banned==0)No
                                    @else Yes
                                    @endif
    </p>

@endsection