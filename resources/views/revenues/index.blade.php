@extends('layouts.app')
@section('title') Revenues Index @endsection

@section('content')
<div class="container">
        <div class="card">
        @if(auth()->user()->hasRole('admin'))
            <div class="card-header">Pharmacies Revenues</div>
            @else
            <div class="card-header">Pharmacy Revenue</div>
            @endif
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
 