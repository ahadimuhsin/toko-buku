@extends('layouts.global')

@section('title')
    Create Category
@endsection

@section('content')
    <div class="col-md-12">
        <form method="post" enctype="multipart/form-data"
              action="{{route('categories.store')}}"
              class="bg-white shadow-sm p-3">
            @csrf

            {{-- <p><strong>Masukkan Data Kategori</strong></p>
            <br><br> --}}

            <label for="name">Category Name</label>
            <input type="text" class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}" name="name"
            value="{{ old('name') }}">
            <div class="invalid-feedback">
                {{ $errors->first('name') }}
            </div>
            <br>

            <label for="image">Category Image</label>
            <input type="file" class="form-control {{ $errors->first('image') ? 'is-invalid' :  ''}}" name="image">
            <div class="invalid-feedback">
                {{ $errors->first('image') }}
            </div>
            <br>

            <input type="submit" class="btn btn-primary" value="Save">
        </form>
    </div>
@endsection
