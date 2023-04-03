@extends('layouts.app')


@section('title') Edit @endsection

@section('content')

@if ($errors->any())
<br>
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{route('pharmacies.update',$pharmacy->id)}}" method="POST" enctype="multipart/form-data">
  @csrf
  @method ("PUT")
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Pharmacy Owner's name</label>
      <input name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$pharmacy->name}}">
    </div>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Email</label>
      <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$pharmacy->email}}">
    </div>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Password</label>
      <input name="password" type="password" class="form-control" id="exampleFormControlTextarea1" rows="3">
    </div>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">National ID</label>
      <input name="national_id" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$pharmacy->national_id}}">
    </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Avatar Image</label>
        <input name="image" type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
      </div>
      @if(auth()->user()->hasRole('admin'))
      <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Priority</label>
      <input name="priority" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    @endif
    @if(auth()->user()->hasRole('admin'))
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Area</label>
      <select name="area_id" class="form-control">
          @foreach($areas as $area)
              <option value="{{$area->id}}">{{$area->name}}</option>
          @endforeach
      </select>
    </div>
    @endif
    <button type="submit" class="btn btn-primary">Update</button>
  </form>
 

@endsection