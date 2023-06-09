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


    <form method="POST" action="{{route('medicines.store')}}" enctype="multipart/form-data">
        @csrf

    @role('admin')
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Pharmacy</label>
      <select name="pharmacy_id" class="form-control">
          @foreach($pharmacies as $pharmacy)
              <option value="{{$pharmacy->id}}">{{$pharmacy->type->name}}</option>
          @endforeach
      </select>
    </div>
    @endrole
        
        <div class="mb-3">
            <label for="name" class="form-label">Medicine Name</label>
            <input name="name" type="text" class="form-control" id="name">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Choose from existing medicines</label>
            <select name="existingMedicine" class="form-control">
            <option>none</option>
          @foreach($medicines as $medicine)
              <option name="name" type="text" class="form-control" id="name" value="{{$medicine->id}}">{{$medicine->name}}</option>
          @endforeach
      </select>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input name="type" type="text" class="form-control" id="type">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input name="price" type="text" class="form-control" id="price">
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input name="quantity" type="text" class="form-control" id="quantity">
        </div>
        

        <button class="btn btn-success">Create</button>
    </form>
@endsection