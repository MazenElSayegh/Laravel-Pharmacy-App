@extends('layouts.app')
@section('content')

<div class="card">
  <div class="card-body">
    {{-- @dd($client); --}}
    <p class="card-text">NAME: {{$client->name}}</p>
    <p class="card-text">EMAIL: {{$client->email}}</p>
    <p class="card-text">NATIONAL ID: {{$client->national_id}}</p>
    <p class="card-text">BIRTHDAY: {{$client->birth_day}}</p>
    <p class="card-text">MOBILE: {{$client->mobile}}</p>
    <p class="card-text">GENDER: {{$client->gender}}</p>
  </div>
</div>

@endsection