@extends('layouts.sub')
@section('title') {{$client->type->name}} @endsection
@section('backtolink') <a href="{{route('clients.index')}}" class="nav-link">All Clients</a> @endsection
@section('content')

<div class="card">
  <div class="card-header bg-primary"></div>
  <div class="card-body">
    <p class="card-header"><img src="{{asset('/storage/' .$client->avatar)}}" class="img-fluid" width="50px">&nbsp; {{$client->type->name}}</p>
    <p class="card-text">EMAIL: {{$client->type->email}}</p>
    <p class="card-text">NATIONAL ID: {{$client->national_id}}</p>
    <p class="card-text">BIRTHDAY: {{$client->birth_day}}</p>
    <p class="card-text">MOBILE: {{$client->mobile}}</p>
    <p class="card-text">GENDER: {{$client->gender}}</p>
  </div>
</div>

@endsection