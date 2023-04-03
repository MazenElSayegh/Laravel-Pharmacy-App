@extends('layouts.sub')
@section('title') {{$client->type->name}} @endsection
@section('backtolink') <a href="{{route('clients.index')}}" class="nav-link">All Clients</a> @endsection
@section('content')

<img src="{{asset('/storage/' .$client->avatar)}}" class="img-fluid w-25">
<div class="card">
  <div class="card-body">
    <p class="card-text">NAME: {{$client->type->name}}</p>
    <p class="card-text">EMAIL: {{$client->type->email}}</p>
    <p class="card-text">NATIONAL ID: {{$client->national_id}}</p>
    <p class="card-text">BIRTHDAY: {{$client->birth_day}}</p>
    <p class="card-text">MOBILE: {{$client->mobile}}</p>
    <p class="card-text">GENDER: {{$client->gender}}</p>
  </div>
</div>

@endsection