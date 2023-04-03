@extends('layouts.app')

@section('title') Pharmacies Index @endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Revenue</div>
        <div class="text-center"></div>
    </div>
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
        @role('pharmacy')
        <tr>
        <td>avatar</td>
        <td>{{auth()->user()->name}}</td>
        <td></td>
        <td></td>
        @else
        @foreach($pharmacies as $pharmacy)
        <tr>
        <td>avatar</td>
        <td>{{$pharmacy->type->name}}</td>
        <td>{{$orders}}</td>
        <td>{{$totalPrice}}</td>
        @endforeach
        @endrole
        </tr>
        </tbody>
        
    </table>
</div>
@endsection