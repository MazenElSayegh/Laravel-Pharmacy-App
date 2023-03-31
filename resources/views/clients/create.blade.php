{{-- @extends('layouts.app')
@section('content') --}}

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
    <form method="POST" action="
        {{isset($client)?route('clients.update', ['client'=>$client->id]):route('clients.store')}}" enctype="multipart/form-data">
        @csrf
        @isset($client)
        @method('PUT')
        @endisset
        <div class="form-group">
            <label for="exampleFormControlInput1">name</label>
            <input type="text" name="name" class="form-control" id="exampleFormControlInput1" value="{{isset($client)?$client->type->name:''}}">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput2">email</label>
            <input type="text" name="email" class="form-control" id="exampleFormControlInput2" value="{{isset($client)?$client->type->email:''}}">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput2">password</label>
            <input type="text" name="password" class="form-control" id="exampleFormControlInput2" value="{{isset($client)?$client->type->email:''}}">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput4">national id</label>
            <input type="text" name="national_id" class="form-control" id="exampleFormControlInput4" value="{{isset($client)?$client->national_id:''}}">
        </div>
        <div class="form-group">
            <label>Birth Day:</label>

            <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
            </div>
                <input type="date" id="birthday" name="birth_day" value="{{isset($client)?$client->birth_day:''}}">
            </div>
            <!-- /.input group -->
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput5">Mobile Phone</label>
            <input type="text" name="mobile" class="form-control" id="exampleFormControlInput5" value="{{isset($client)?$client->national_id:''}}">
        </div>
            <label class="form-check-label" for="exampleRadios1">
                Gender
            </label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" id="exampleRadios1" value="female" {{isset($client)?$client->is_baned? "checked":'':''}}>
            <label class="form-check-label" for="exampleRadios1">
                female
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" id="exampleRadios2" value="male" {{isset($client)?$client->is_baned? "":'checked':''}}>
            <label class="form-check-label" for="exampleRadios2">
                male
            </label>
        </div>
        <div class="form-group">
            <input type="file" name="avatar" value="{{isset($client)?$client->avatar:''}}">
        </div>
        <button class="btn btn-success m-3" type="submit">Store</button>
    </form>
</div>

{{-- @endsection --}}