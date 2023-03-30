{{-- @extends('layouts.app')
@section('content') --}}

<div class="card">
  <div class="card-body">
    <p class="card-text">NAME: {{$doctor->name}}</p>
    <p class="card-text">EMAIL: {{$doctor->email}}</p>
    <p class="card-text">NATIONAL ID: {{$doctor->national_id}}</p>
    <p class="card-text">BIRTHDAY: {{$doctor->is_banned}}</p>
  </div>
</div>

{{-- @endsection --}}