@extends('layouts.global')

@section('title')
    Edit Book
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <form enctype="multipart/form-data"
            method="post"
            action="{{ route('books.update', $book->id) }}"
            class="p-3 shadow-sm bg-white">

                @csrf
                @method('put')

                <label for="title">Title</label><br>
                <input type="text" class="form-control {{ $errors->first('title') ? 'is-invalid' : '' }}"
                name="title" placeholder="Judul Buku"
                value="{{ old('title') ? old('title') : $book->title }}">
                <div class="invalid-feedback">
                    {{ $errors->first('title') }}
                </div>
                <br>

                <label for="cover">Cover</label><br>
                <small class="text-muted">Current cover</small>
                <br>
                @if($book->cover)
                    <img src="{{ asset('storage/'.$book->cover) }}" width="96px">
                @endif
                <br><br>
                <input type="file" class="form-control {{ $errors->first('cover') ? 'is-invalid' : '' }}" name="cover">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah cover</small>
                <div class="invalid-feedback">
                    {{ $errors->first('cover') }}
                </div>
                <br>

                <label for="slug">Slug</label><br>
                <input type="text"
                class="form-control {{ $errors->first('slug') ? 'is-invalid' : '' }}"
                value="{{ old('slug') ? old('slug') : $book->slug }}"
                name="slug"
                placeholder="enter-a-slug">
                <div class="invalid-feedback">
                    {{ $errors->first('slug') }}
                </div>
                <br>

                <label for="description">Description</label><br>
                <textarea name="description" id="description" class="form-control {{ $errors->first('description') ? 'is-invalid' : '' }}"
                placeholder="Deskripsi buku ini">{{ old('descriotion') ? old('description') : $book->description }}</textarea>
                <div class="invalid-feedback">
                    {{ $errors->first('description') }}
                </div>
                <br>

                {{-- Menggunakan Select2 untuk dropdownnya --}}
                <label for="categories">Categoriesss</label>
                <br>
                <select name="categories[]"
                multiple
                id="categories"
                class="form-control">
                </select>

                <br>
                <label for="stock">Stock</label><br>
                <input type="number" class="form-control {{ $errors->first('stock') ? 'is-invalid' : '' }}" name="stock"
                id="stock" min=0 value={{ old('stock') ? old('stock'): $book->stock }}>
                <div class="invalid-feedback">
                    {{ $errors->first('stock') }}
                </div>
                <br>

                <label for="author">Author</label><br>
                <input type="text" class="form-control {{ $errors->first('author') ? 'is-invalid' : '' }}" name="author"
                id="author" placeholder="Penulis buku" value="{{ old('author') ? old('author') : $book->author }}">
                <div class="invalid-feedback">
                    {{ $errors->first('author') }}
                </div>
                <br>

                <label for="publisher">Publisher</label><br>
                <input type="text" class="form-control {{ $errors->first('publisher') ? 'is-invalid' : '' }}" name="publisher"
                id="publisher" placeholder="Penerbit Buku"
                value="{{ old('publisher') ? old('publisher') : $book->publisher }}">
                <div class="invalid-feedback">
                    {{ $errors->first('publisher') }}
                </div>
                <br>

                <label for="price">Price</label><br>
                <input type="number" class="form-control {{ $errors->first('price') ? 'is-invalid' : '' }}" name="price" id="price"
                placeholder="Harga Buku" value="{{old('price') ? old('price') : $book->price }}">
                <div class="invalid-feedback">
                    {{ $errors->first('price') }}
                </div>
                <br>

                <label for="weight">Weight</label><br>
                <input type="number" step="0.01" class="form-control {{ $errors->first('weight') ? 'is-invalid' : '' }}"
                       name="weight" id="weight"
                       placeholder="Berat Buku dalam kg" value="{{old('weight') ? old('weight') : $book->weight}}">
                <div class="invalid-feedback">
                    {{ $errors->first('weight') }}
                </div>
                <br>

               <label for="status"></label><br>
               <select name="status" id='status' class="form-control">
                   <option {{ $book->status == 'PUBLISH' ? 'selected' : ''}}
                    value="PUBLISH">PUBLISH</option>
                    <option {{ $book->status == 'DRAFT' ? 'selected' : ''}}
                    value="DRAFT">DRAFT</option>
               </select>
               <br>

               <button class="btn btn-primary" value="PUBLISH">Update</button>
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
            });
        });
        var categories = {!! $book->categories !!}

            categories.forEach(function(category){
                var option = new Option(category.name, category.id, true, true);
                $('#categories').append(option).trigger('change');
            });
    </script>
@endsection
