@extends('layouts.sub')

@section('title') Order #{{$order->id}} @endsection
@section('backtolink') <a href="{{route('orders.index')}}" class="nav-link">All Orders</a> @endsection

@section('content')

@if($order->prescription_image)
<img src="{{asset('/storage/' .$order->prescription_image)}}" class="img-fluid w-25">
@endif
<div class="card">
  <div class="card-body">
    <p class="card-text">Client Name: {{$order->client->type->name}}</p>
    {{-- @dd($medicine_order[0]->medicine->name); --}}

      @foreach($medicine_order as $medicine)
      <h5>Medicine Name: {{$medicine->medicine->name}}</h5>
      <ul>
        <li>Medicine Type: {{$medicine->medicine->type}}</li>
        <li>Medicine Quantity: {{$medicine->quantity}}</li>
      </ul>
  
      @endforeach
      <p class="card-text">Order Total Price: {{$order->total_price}}$</p>
      <p class="card-text">Client Address: {{$order->address->street_name}}</p>
          
  </div>
  

@endsection