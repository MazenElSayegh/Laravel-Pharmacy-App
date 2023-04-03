@extends('layouts.app')


@section('title') Create @endsection

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

<form action="{{route('pharmacies.store')}}" method="POST" enctype="multipart/form-data">
  @csrf
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Pharmacy Owner's name</label>
      <input name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Email</label>
      <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Password</label>
      <input name="password" type="password" class="form-control" id="exampleFormControlTextarea1" rows="3">
    </div>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Doctor's national id</label>
      <input name="national_id" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Avatar Image</label>
        <input name="avatar_image" type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Priority</label>
      <input name="priority" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>

    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Area</label>
      <select name="area_id" class="form-control">
          @foreach($areas as $area)
              <option value="{{$area->id}}">{{$area->id}}</option>
          @endforeach
      </select>
    </div>
    <button type="submit" class="btn btn-success">Create</button>
  </form>
 

@endsection