@extends('layouts.app')

@section('title') Revenue Index @endsection

@section('content')
<div class="container">
    @role('pharmacy')
    <div class="card">
        <div class="card-header">Revenue = ${{$revenue/100}}</div>
        <div class="card-header">Orders count = {{$ordersCount}}</div>
    </div>
    @endrole
    @role('admin')
    <table id="mytable" class="table mt-4">
        <thead>
            <tr>
                <th>Pharmacy Avatar</th>
                <th>Pharmacy Name</th>
                <th>Total Orders</th>
                <th>Total Revenue</th>
            </tr>
        </thead>

        <tbody>
        @foreach($pharmacies as $pharmacy)
        <tr>
        <td><img src="{{asset('/storage/' . $pharmacy->avatar_image)}}"></td>
        <td>{{$pharmacy->type->name}}</td>
        <td>{{$pharmacy->orders->count()}}</td>
        @foreach($pharmacy->orders as $order)
        <p style="display: none;">{{$totalPrice+=$order->total_price}}</p>
        @endforeach
        <td>${{$totalPrice/100}}</td>
        <p style="display: none">{{$totalPrice=0}}</p>
        </tr>
        @endforeach
        </tbody>
        
    </table>
    @endrole
</div>
@endsection