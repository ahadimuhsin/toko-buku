@extends('layouts.global')

@section('title')
    List Buku
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session('status'))
             <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session('status')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('books.index') }}">
                    <div class="input-group">
                        <input name="keyword" type="text"
                        value="{{ Request::get('keyword') }}"
                        class="form-control" placeholder="Filter berdasarkan judul">
                        <div class="input-group-append">
                            <input type="submit" value="Filter" class="btn btn-primary">
                        </div>
                    </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <ul class="nav nav-pills card-header-pills">
                        <li class="nav-item">
                            <a class="nav-link
                            {{ Request::get('status') == NULL && Request::path() == 'books' ? 'active' : '' }}"
                            href="{{ route('books.index') }}">
                            All</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link
                            {{ Request::get('status') == 'publish' ? 'active' : '' }}"
                            href="{{ route('books.index', ['status' => 'publish']) }}">
                            Publish</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link
                            {{ Request::get('status') == 'draft' ? 'active': ''}}"
                            href="{{ route('books.index', ['status' => 'draft']) }}">
                            Draft</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                            {{ Request::path() == 'books/trash' ? 'active' : '' }}
                            href="{{ route('books.trash') }}">
                            Trash</a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="my-3">
            <div class="row mb-3">
                <div class="col-md-12 text-right">
                    <a href="{{ route('books.create') }}"
                    class="btn btn-outline-primary">
                    <i class="oi oi-plus"></i>Add Book </a>
                </div>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><b>Cover</b></th>
                        <th><b>Title</b></th>
                        <th><b>Author</b></th>
                        <th><b>Status</b></th>
                        <th><b>Categories</b></th>
                        <th><b>Stock</b></th>
                        <th><b>Price</b></th>
                        <th><b>Action</b></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                    <tr>
                        <td>
                            @if($book->cover)
                            <img src="{{ asset('storage/'.$book->cover) }}"
                            width="96px">
                            @endif
                        </td>
                        <td>
                            {{ $book->title }}
                        </td>
                        <td>
                            {{ $book->author }}
                        </td>
                        <td>
                            @if($book->status == "DRAFT")
                            <span class="badge bg-dark text-white">{{ $book->status }}</span>
                            @else
                            <span class="badge badge-success">{{ $book->status }}</span>
                            @endif
                        </td>
                        <td>
                            <ul class="pl-3">
                                @foreach ($book->categories as $category)
                                    <li>{{ $category->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $book->stock }}</td>
                        <td>Rp {{ number_format($book->price, 0, '', '.') }}</td>
                        <td>
                            <a class="btn btn-info text-white btn-sm"
                        href="{{route('books.edit', $book->id)}}"><i class="oi oi-pencil"></i>Edit</a>
                        <form
                            onsubmit="return confirm('Yakin hapus kategori ini?')"
                            class="d-inline"
                            action="{{route('books.destroy', $book->id)}}"
                            method="post">

                            @csrf
                            @method('delete')

                            <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                            {{-- <a href="{{ route('categories.show', $category->id_category) }}" class="btn btn-primary btn-sm">
                                <i class="oi oi-book"></i>Detail
                            </a> --}}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Data kosong</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10">
                            {{ $books->appends(Request::all())->links() }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
