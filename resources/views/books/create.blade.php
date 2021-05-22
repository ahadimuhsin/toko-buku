@extends('layouts.global')

@section('title')
    Tambah Buku
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('books.store') }}" method="POST"
            enctype="multipart/form-data" class="shadow-sm p-3 bg-white">

            @csrf

            <label for="title">Title</label><br>
            <input type="text" class="form-control {{ $errors->first('title') ? 'is-invalid' : '' }}"
            name="title" placeholder="Judul Buku" value="{{ old('title') }}">
            <div class="invalid-feedback">
                {{ $errors->first('title') }}
            </div>
            <br>

            <label for="cover">Cover</label>
            <input type="file" class="form-control {{ $errors->first('cover') ? 'is-invalid' : '' }}" name="cover">
            <div class="invalid-feedback">
                {{ $errors->first('cover') }}
            </div>
            <br>

            <label for="description">Description</label><br>
            <textarea name="description" id="description" class="form-control {{ $errors->first('description') ? 'is-invalid' : '' }}"
            placeholder="Deskripsi buku ini" rows="10">{{ old('description') }}</textarea>
            <div class="invalid-feedback">
                {{ $errors->first('description') }}
            </div>
            <br>

            {{-- Menggunakan Select2 untuk dropdownnya --}}
            <label for="categories">Categories</label>
            <br>
            <select name="categories[]"
            multiple
            id="categories"
            class="form-control">
            </select>

            <br>
            <label for="stock">Stock</label><br>
            <input value="{{ old('stock') }}" type="number" class="form-control {{ $errors->first('stock') ? 'is-invalid' : '' }}" name="stock"
            id="stock" min=0 value=0>
            <div class="invalid-feedback">
                {{ $errors->first('stock') }}
            </div>
            <br>

            <label for="author">Author</label><br>
            <input type="text" class="form-control {{ $errors->first('author') ? 'is-invalid' : '' }}" name="author"
            id="author" placeholder="Penulis buku" value="{{ old('author') }}">
            <div class="invalid-feedback">
                {{ $errors->first('author') }}
            </div>
            <br>

            <label for="publisher">Publisher</label><br>
            <input type="text" class="form-control {{ $errors->first('publisher') ? 'is-invalid' : '' }}" name="publisher"
            id="publisher" placeholder="Penerbit Buku" value="{{ old('publisher') }}">
            <div class="invalid-feedback">
                {{ $errors->first('publisher') }}
            </div>
            <br>

            <label for="price">Price</label><br>
            <input type="number" class="form-control {{ $errors->first('price') ? 'is-invalid' : '' }}" name="price" id="price"
            placeholder="Harga Buku" value="{{ old('price') }}">
            <div class="invalid-feedback">
                {{ $errors->first('price') }}
            </div>
            <br>

            <label for="weight">Weight</label><br>
            <input type="number" step="0.01" class="form-control {{$errors->first('weight') ? 'is-invalid' : ''}}" name="weight" id="weight"
             placeholder="Berat Buku dalam kg" value="{{old('weight')}}">
            <br>
            {{-- Menyimpan sebagai PUBLISH --}}
            <button class="btn btn-primary"
            name="save_action"
            value="PUBLISH">Save as Publish</button>

            {{-- Menyimpan sebagai DRAFT --}}
            <button class="btn btn-secondary"
            name="save_action"
            value="DRAFT">Save as Draft</button>
            </form>
        </div>
    </div>
@endsection

@section('footer-scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#categories').select2({
                ajax: {
                    url : '{{ url('ajax/categories/search') }}',
                    processResults: function(data){
                        return {
                            results: data.map(function(item){
                                return {
                                    id: item.id,
                                    text: item.name
                                }
                            })
                        }
                    }
                }
            })
        });
    </script>
@endsection
