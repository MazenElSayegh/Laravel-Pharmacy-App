@extends('layouts.sub')

@section('title')
    Edit
@endsection

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


    <form method="POST" action="{{route('medicines.update', $medicine)}}" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input name="name" type="text" class="form-control" id="name" value="{{$medicine->name}}">
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input name="type" type="text" class="form-control" id="type" value="{{$medicine->type}}">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input name="price" type="text" class="form-control" id="price" value="{{$medicine->price}}">
        </div>
        

        <button class="btn btn-primary">Update</button>
    </form>
@endsection