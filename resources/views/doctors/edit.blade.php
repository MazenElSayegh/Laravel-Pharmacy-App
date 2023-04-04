@extends('layouts.sub')


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

<form action="{{route('doctors.update',['doctor' => $doctor['id']])}}" method="POST" enctype="multipart/form-data">
  @csrf
  @method ("PUT")
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Doctor's name</label>
      <input name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$doctor->type->name}}">
    </div>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Doctor's email</label>
      <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$doctor->type->email}}">
    </div>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Password</label>
      <input name="password" type="password" class="form-control" id="exampleFormControlTextarea1" rows="3">
    </div>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Doctor's national id</label>
      <input name="national_id" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$doctor->national_id}}">
    </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Avatar Image</label>
        <input name="avatar_image" type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
      </div>
      @if(auth()->user()->hasRole('admin'))
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Pharmacy name</label>
      <select name="pharmacy_id" class="form-control">
          @foreach($pharmacies as $pharmacy)
              <option value="{{$pharmacy->id}}">{{$pharmacy->type->name}}</option>
          @endforeach
      </select>
    </div>
    @endif
    <button type="submit" class="btn btn-primary">Update</button>
  </form>
 

@endsection