@extends('layouts.app')

@section('title')
    {{$area->name}}
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{$area->name}}</h3>
      <div class="card-tools">
        <span class="badge badge-primary">Area</span>
      </div>
      <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div><b>Name: </b> {{$area->name}}</div>
      <div><b>Address: </b> {{$area->address}}</div>
      <div><b>Created At: </b> {{$area->created_at}}</div>
      <div><b>Updated At: </b> {{$area->updated_at}}</div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <a href="{{route('areas.index')}}" btn btn-primary>Back To Areas</a>
    </div>
    <!-- /.card-footer -->
  </div>
  <!-- /.card -->
@endsection