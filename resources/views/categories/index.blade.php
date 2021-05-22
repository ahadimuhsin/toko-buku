@extends('layouts.global')


@section('title')
    Daftar Kategori
@endsection

@section('content')
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('categories.index') }}">
                <div class="input-group">
                    <input type="text" class="form-control"
                    placeholder="Filter berdasarkan nama kategori"
                    name="name" value="{{ Request::get('name') }}">
                    <div class="input-group-append">
                        <input type="submit" value="Filter"
                        class="btn btn-primary">
                        <a href="{{ route('categories.create') }}" class="btn btn-outline-primary" style="float: right; margin-left: 370px;  margin-right: -540px">
                <i class="oi oi-plus"></i>Tambah Data Kategori</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('categories.index') }}">Published</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('categories.trash') }}">Trash</a>
                </li>
            </ul>
        </div>
    </div>

    <hr class="my-3">
    <div class="row">
        @if(session('status'))
            <div class="col-md-12">
             <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session('status')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            </div>
        @endif
        <div class="col-md-12">

            <table class="table table-bordered table-stripped">
                <thead>
                    <tr>
                        <th align="center"><b>Name</b></th>
                        <th align="center"><b>Slug</b></th>
                        <th align="center"><b>Image</b></th>
                        <th align="center"><b>Actions</b></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td align="center">
                            @if($category->image)
                            <img src="{{ asset('storage/'.$category->image) }}"
                            width="48px">
                            @else
                            <img src="https://www.mhcsa.org.au/wp-content/uploads/2016/08/default-non-user-no-photo.jpg"
                            width="48px">
                            @endif
                        </td>
                        <td align="center">
                             <a class="btn btn-info text-white btn-sm"
                        href="{{route('categories.edit', $category->id)}}"><i class="oi oi-pencil"></i>Edit</a>
                        <form
                            onsubmit="return confirm('Yakin hapus kategori {{ $category->name }}?')"
                            class="d-inline"
                            action="{{route('categories.destroy', $category->id)}}"
                            method="post">

                            @csrf
                            @method('delete')

                            <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                            <a href="{{ route('categories.show', $category->id) }}" class="btn btn-primary btn-sm">
                                <i class="oi oi-book"></i>Detail
                            </a>
                        </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Data Kosong</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10">
                            {{ $categories->appends(Request::all())->links() }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
