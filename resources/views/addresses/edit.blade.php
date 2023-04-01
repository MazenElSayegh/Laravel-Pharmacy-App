@extends('layouts.app')
@section('content')

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="container">
    <form method="POST" action="{{route('addresses.update', $address->id)}}" enctype="multipart/form-data">
    @method('PUT')    
    @csrf
        <label for="client_id">Client</label>
        <select class="form-control" name="client_id">
            @foreach($clients as $client)
            <option value="{{$client->id}}" {{($client->id == $address->client_id) ? 'selected' : ''}}>{{$client->type->name}}</option>
            @endforeach
        </select>
        <div class="form-group">
            <label for="street_name">street_name</label>
            <input type="text" name="street_name" class="form-control" id="street_name" value="{{$address->street_name}}">
        </div>
        <div class="form-group">
            <label for="build_no">build_no</label>
            <input type="text" name="build_no" class="form-control" id="build_no" value="{{$address->build_no}}">
        </div>
        <div class="form-group">
            <label for="floor_no">floor_no</label>
            <input type="text" name="floor_no" class="form-control" id="floor_no" value="{{$address->floor_no}}">
        </div>
        <div class="form-group">
            <label for="flat_no">flat_no</label>
            <input type="text" name="flat_no" class="form-control" id="flat_no" value="{{$address->flat_no}}">
        </div>
        <label for="area_id">Area</label>
        <select class="form-control" name="area_id">
            @foreach($areas as $area)
            <option value="{{$area->id}}" {{($area->id == $address->area->id) ? 'selected' : ''}} >{{$area->address}}</option>
            @endforeach
        </select>

        <div class="form-group">
            <h4>thats your main address ?</h4>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_main" id="male" value="1" {{($address->is_main) ? 'checked' : ''}}>
                <label class="form-check-label" for="male">
                    Yes
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_main" id="female" value="0" {{(!$address->is_main) ? 'checked' : ''}}>
                <label class="form-check-label" for="female">
                    No
                </label>
            </div>
        </div>
        
        <button class="btn btn-success m-3" type="submit">Submit</button>
    </form>
</div>

    @endsection