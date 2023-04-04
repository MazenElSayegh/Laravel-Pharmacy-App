@extends('layouts.app')
@section('title') Pharmacies Index @endsection

@section('content')
<div class="container">
        <div class="card">
        @if(auth()->user()->hasRole('admin'))
            <div class="card-header">Manage Pharmacy Owners</div>
            @else
            <div class="card-header">Manage Pharmacy</div>
            @endif
            <div class="text-center">
        @if(auth()->user()->hasRole('admin'))
        <button type="button" class="mt-4 btn btn-success"><a href="{{route('pharmacies.create')}}" style="color:white;text-decoration:none;">Create Pharmacy</a></button>
        @endif
    </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
</div>
<div class="container">
        <div class="card">
            <div class="card-header">Deleted Pharmacies</div>
<table class="table mt-4">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">National ID</th>
            <th scope="col">Email</th>
            <th scope="col">Priority</th>
            <th scope="col">Area</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>

        @foreach($pharmacies as $pharmacy)
            <tr>
                <td>{{$pharmacy->id}}</td>
                @foreach($users as $user)
                @if($user->typeable_id==$pharmacy->id)
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                @endif
                @endforeach
                <td>{{$pharmacy->national_id}}</td>
                <td>{{$pharmacy->priority}}</td>
                <td>{{$pharmacy->area->name}}</td>
                <td>
                    <a href="{{route('pharmacies.restore',$pharmacy->id)}}"" class="btn btn-info">Restore</a>
                </form>
                </td>
            </tr>
  
        @endforeach
        </tbody>
    </table>
</div>
</div>
</div>
    @endsection
    @push('scripts')
    {{ $dataTable->scripts() }}
    @endpush
 



   