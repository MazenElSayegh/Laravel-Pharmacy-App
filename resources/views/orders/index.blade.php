@extends('layouts.app')

@section('title') Orders Index @endsection

@section('content')
<div class="container">
        <div class="card">
            <div class="card-header">Manage Orders</div>
            <div class="text-center">
        <button type="button" class="mt-4 btn btn-success"><a href="{{route('orders.create')}}" style="color:white;text-decoration:none;">Create Order</a></button>
        </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
</div>
    
    @endsection
    @push('scripts')
    {{ $dataTable->scripts() }}
    @endpush
 



   