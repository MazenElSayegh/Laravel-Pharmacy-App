@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @role('admin')
                <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image" width="200px">
                @else
                <img src="{{asset('/storage/' .auth()->user()->typeable->image_path)}}" class="img-fluid w-25">
                @endrole
                <div class="card-header">Hello {{auth()->user()->name}}</div>
                <div class="card-header">Email: {{auth()->user()->email}}</div>
                <div class="card-header">Your Role: {{ucfirst(str_replace(['[',']','"'],"",auth()->user()->getRoleNames()))}}</div>
                @role('admin')
                    <div class='card-header'>YOU CAN DO EVERYTHING!</div>
                @else
                @role('pharmacy')
                    <div class='card-header'>You can access Doctors ,Orders ,and Medicines</div>
                @else
                    <div class='card-header'>You can access Orders only</div>
                    @if(auth()->user()->typeable->is_banned == 1)
                        <div class="card-header">You are banned and can't make orders</div>
                    @endif
                @endrole
                @endrole
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
