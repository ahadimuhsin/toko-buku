@extends('layouts.global')

@section('title')
    Edit Data User
@endsection

@section('pageTitle')
    Edit Data User {{$user->nama}}
@endsection

@section('content')
    <div class="col-md-8">

        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif

        <form enctype="multipart/form-data" class="bg-white shadow-sm p-3"
        action="{{route('users.update', $user->id)}}" method="post">

            @csrf
            @method('PUT')

            <label for="name">Name</label>
            <input class="form-control {{ $errors->first('name') ? "is-invalid" : '' }}" placeholder="Full Name"
                   type="text" name="name" id="name"
                   value="{{old('name') ?  old('name')  : $user->name}}">
            <div class="invalid-feedback">
                {{ $errors->first('name') }}
            </div>
            <br>

            <label for="username">Username</label>
            <input class="form-control" placeholder="username"
                   type="text" name="username" id="username" disabled
            value="{{$user->username}}">
            <br>

            <label for="email">Email</label>
            <input type="email" name="email"
                   class="form-control"
                   value="{{$user->email}}"
                    id="email" disabled>
            <br>

            <br>
            <label for="">Status</label>
            <br>
            <input {{$user->status == "ACTIVE" ? "checked" : ""}}
            value="ACTIVE" type="radio" class="form-control" id="active"
                   name="status">
            <label for="active">Active</label>

            <input {{$user->status == "NONACTIVE" ? "checked" : ""}}
                   value="NONACTIVE" type="radio" class="form-control" id="nonactive"
                   name="status">
            <label for="nonactive">Nonactive</label>
            <br><br>

            <label for="">Role(s)</label>
            <br>
            <input
                type="checkbox" {{in_array("ADMIN", json_decode($user->roles)) ? "checked" : ""}}
                name="roles[]"
                id="admin"
                value="ADMIN"
                class="form-control {{ $errors->first('roles') ? "is-invalid" : '' }}">
            <label for="ADMIN">Administrator</label>

            <input
                type="checkbox" {{in_array("STAFF", json_decode($user->roles)) ? "checked" : ""}}
            name="roles[]"
                id="staff"
                value="STAFF"
                class="form-control {{ $errors->first('roles') ? "is-invalid" : '' }}">
            <label for="STAFF">Staff</label>

            <input
                type="checkbox" {{in_array("CUSTOMER", json_decode($user->roles)) ? "checked" : ""}}
            name="roles[]"
                id="customer"
                value="CUSTOMER"
                class="form-control {{ $errors->first('roles') ? "is-invalid" : '' }}">
            <label for="CUSTOMER">Customer</label>

            <div class="invalid-feedback">
                {{ $errors->first('roles') }}
            </div>

            <br>

            <label for="phone">Phone Number</label>
            <input type="text" name="phone"
                   class="form-control {{ $errors->first('phone') ? 'is-invalid' : '' }}"
                   value="{{old('phone') ? old('phone') : $user->phone}}">
            <div class="invalid-feedback">
                {{ $errors->first('phone') }}
            </div>

            <br>
            <label for="address">Address</label>
            <textarea name="address" id="address"
            class="form-control {{ $errors->first('address') ? 'is-invalid' : '' }}">{{old('address') ? old('address') : $user->address}}</textarea>

            <div class="invalid-feedback">
                {{ $errors->first('address') }}
            </div>

            <br>
            <label for="avatar">Avatar Image</label>
            <br>
            Current avatar: <br>
            @if($user->avatar)
                <img src="{{asset('public/storage/'.$user->avatar)}}" width="120px">
                <br>
            @else
            No Photo
            @endif
            <br>
            <input id="avatar" name="avatar" type="file" class="form-control">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah avatar</small>
            <br>
            <br>
            <input class="btn btn-primary" type="submit" value="Save">
        </form>
    </div>
@endsection
