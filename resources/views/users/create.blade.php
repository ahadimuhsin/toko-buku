@extends('layouts.global')

@section('title')
    Tambah User
@endsection

@section('pageTitle')
    Buat User Baru
@endsection

@section('content')
    <div class="col-md-8">

        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif

        {{--Buat Form--}}
        <form action="{{route('users.store')}}"
              method="post"
              class="bg-white shadow-sm p-3"
              enctype="multipart/form-data">
            {{--dont forget the csrf--}}
            @csrf

            <label for="name">Name</label>
            <input
            class="form-control {{ $errors->first('name') ? "is-invalid" : '' }}"
             placeholder="Full Name"
            type="text" name="name" id="name"
            value="{{ old('name') }}">
            <div class="invalid-feedback">
                {{ $errors->first('name') }}
            </div>
            <br>

            <label for="username">Username</label>
            <input class="form-control {{ $errors->first('username') ? "is-invalid" : '' }}" placeholder="username"
                   type="text" name="username" id="username" value="{{ old('username') }}">
            <div class="invalid-feedback">
                {{ $errors->first('username') }}
            </div>
            <br>

            <label for="password">Password</label>
            <input type="password" name="password" id="password"
            class="form-control {{ $errors->first('password') ? "is-invalid" : '' }}">
            <div class="invalid-feedback">
                {{ $errors->first('password') }}
            </div>
            <br>

            <label for="password_confirmation">Password Confirmation</label>
            <input class="form-control {{ $errors->first('password_confirmation') ? "is-invalid" : '' }}" type="password" name="password_confirmation"
            id="password_confirmation">
            <div class="invalid-feedback">
                {{ $errors->first('password_confirmation') }}
            </div>
            <br>

            <label for="email">Email</label>
            <input class="form-control {{ $errors->first('email') ? "is-invalid" : '' }}" placeholder="yourmail@domain.com" name="email"
                   id="email" type="text" value="{{ old('email') }}">
            <div class="invalid-feedback">
                {{ $errors->first('email') }}
            </div>
            <br>

            {{--Check box untuk pilihan role--}}
            <label for="roles">Role(s)</label>
            <br>
            <input class="form-control {{ $errors->first('roles') ? "is-invalid" : '' }}" type="checkbox" name="roles[]" id="admin" value="ADMIN">
            <label for="ADMIN">Administrator</label>

            <input class="form-control {{ $errors->first('roles') ? "is-invalid" : '' }}" type="checkbox" name="roles[]" id="staff" value="STAFF">
            <label for="STAFF">Staff</label>

            <input class="form-control {{ $errors->first('roles') ? "is-invalid" : '' }}" type="checkbox" name="roles[]" id="customer" value="CUSTOMER">
            <label for="CUSTOMER">CUSTOMER</label>

            <div class="invalid-feedback">
                {{ $errors->first('roles') }}
            </div>
            <br>

            <br>
            <label for="phone">Phone Number</label>
            <input type="text" name="phone"
            class="form-control {{ $errors->first('phone') ? "is-invalid" : '' }}"
            value="{{ old('phone') }}">
            <div class="invalid-feedback">
                {{ $errors->first('phone') }}
            </div>
            <br>


            <label for="address">Address</label>
            <textarea name="address" id="address" class="form-control {{ $errors->first('address') ? 'is-invalid' : '' }}">{{ old('address') }}</textarea>
            <div class="invalid-feedback">
                {{ $errors->first('address') }}
            </div>

            <br>
            <label for="avatar">Avatar Image</label>
            <input id="avatar" name="avatar" type="file"
            class="form-control {{ $errors->first('avatar') ? 'is-invalid' : '' }}">

            <div class="invalid-feedback">
                {{ $errors->first('avatar') }}
            </div>
            <br>
            <input class="btn btn-primary" type="submit" value="Save">

        </form>
    </div>
@endsection
