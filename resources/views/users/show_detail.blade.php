@extends('layouts.global')

@section('title')
    Detail User
@endsection

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <b>Name: </b>
                <br>
                {{ $user->name }}
                <br>

                @if($user->avatar)
                    <img src="{{ asset('public/storage/'.$user->avatar) }}" width="128px">
                @else
                    <img src="https://www.mhcsa.org.au/wp-content/uploads/2016/08/default-non-user-no-photo.jpg"
                    width="128px">
                @endif

                <br>
                <br>
                <b>Username:</b><br>
                {{ $user->phone }}

                <br><br>
                <b>Address</b><br>
                {{ $user->address }}

                <br><br>
                <b>Roles:</b><br>
                @foreach(json_decode($user->roles) as $role)
                &middot; {{ $role }}<br>

                @endforeach
            </div>
        </div>
    </div>
@endsection
