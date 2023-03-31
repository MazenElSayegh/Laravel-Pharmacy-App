@extends('layouts.app')

@section('title')
    {{$medicine->name}}
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{$medicine->name}}</h3>
      <div class="card-tools">
        <span class="badge badge-primary">Medicine</span>
      </div>
      <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div><b>Name: </b> {{$medicine->name}}</div>
      <div><b>Type: </b> {{$medicine->type}}</div>
      <div><b>Price: </b> {{$medicine->price}}</div>
      <div><b>Created At: </b> {{$medicine->created_at}}</div>
      <div><b>Updated At: </b> {{$medicine->updated_at}}</div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <a href="{{route('medicines.index')}}" btn btn-primary>Back To Medicines</a>
    </div>
    <!-- /.card-footer -->
  </div>
  <!-- /.card -->
@endsection