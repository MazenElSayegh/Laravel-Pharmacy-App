@extends('layouts.sub')

@section('title') Order #{{$order->id}} @endsection
@section('backtolink') <a href="{{route('orders.index')}}" class="nav-link">All Orders</a> @endsection

@section('content')

@if($order->prescription_image)
<img src="{{asset('/storage/' .$order->prescription_image)}}" class="img-fluid w-25">
@endif
<div class="card">
  <div class="card-header bg-primary"></div>
  <div class="card-body">
    
    <p class="card-header">Client Name: {{$order->client->type->name}}</p>
    {{-- @dd($medicine_order[0]->medicine->name); --}}

      @foreach($medicine_order as $medicine)
      <h5>Medicine Name: {{$medicine->medicine->name}}</h5>
      <ul>
        <li>Medicine Type: {{$medicine->medicine->type}}</li>
        <li>Medicine Quantity: {{$medicine->quantity}}</li>
      </ul>
  
      @endforeach
      <p class="card-header">Order Total Price: {{$order->total_price}} $</p>
      <p class="card-header">Client's Address</p>
      <p class="card-header">Area: {{$order->address->area->name}}
        <br>Street name: {{$order->address->street_name}}
        <br>Building no: {{$order->address->build_no}}
        <br>Floor no: {{$order->address->floor_no}}
        <br>Flat no: {{$order->address->flat_no}}</p>

          
  </div>
  

@endsection