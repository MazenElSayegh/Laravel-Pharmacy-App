@extends('layouts.sub')

@section('title')
    Create
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


    <form method="POST" action="{{route('areas.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input name="name" type="text" class="form-control" id="name">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input name="address" type="text" class="form-control" id="address">
        </div>
        

        <button class="btn btn-success">Create</button>
    </form>
@endsection