@extends('layouts.global')

@section('title')
    Edit Category
@endsection

@section('content')
    <div class="col-md-8">
        <form action="{{ route('categories.update', $category->id) }}"
             method="post"
             enctype="multipart/form-data"
             class="bg-white shadow-sm p-3">

             @csrf
             @method('put')

             <label for="name">Category Name</label>
             <input type="text" class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}"
             value="{{ old('name') ? old('name') : $category->name }}"
             name="name">
             <div class="invalid-feedback">
                 {{ $errors->first('name') }}
             </div>
             <br>

             <label for="slug">Category slug</label>
             <input type="text" class="form-control {{ $errors->first('slug') ? 'is-invalid' : '' }}"
             value="{{ old('slug') ? old('slug') : $category->slug }}"
             name="slug">
             <div class="invalid-feedback">
                 {{ $errors->first('slug') }}
             </div>
             <br>

             <label for="image">Category image</label>
             @if($category->image)
             <span>Current image</span><br>
             <img src="{{ asset('storage/'.$category->image) }}"
             width="120px">
             @endif

             <input type="file" class="form-control {{ $errors->first('image') ? 'is-invalid' : ''}}" name="image">
             <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
             <div class="invalid-feedback">
                 {{ $errors->first('image') }}
             </div>
             <br>

             <input type="submit" class="btn btn-primary" value="Update">
        </form>
    </div>
@endsection
