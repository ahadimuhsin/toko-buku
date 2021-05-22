@extends('layouts.global')

@section('title')
    Tempat Sampah Kategori
@endsection

@section('content')
    <div class="row">

        <div class="col-md-6">
            <form action="{{route('categories.index')}}">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Filter berdasarkan nama kategori"
                    value="{{Request::get('name')}}" name="name">

                    <div class="input-group-append">
                        <input type="submit" value="Filter" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-6">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('categories.index')}}">Published</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('categories.trash')}}">Trash</a>
                </li>
            </ul>
        </div>
    </div>
    <hr class="my-3">

    <div class="row">
       <div class="col-md-12">
           <table class="table table-bordered">
               <thead>
               <tr>
                   <th>Nama</th>
                   <th>Slug</th>
                   <th>Image</th>
                   <th>Action</th>
               </tr>
               </thead>
               <tbody>
               @forelse($categories as $category)
                   <tr>
                       <td>{{$category->name}}</td>
                       <td>{{$category->slug}}</td>
                       <td>
                           @if($category->name)
                               <img src="{{asset('public/storage/'.$category->image)}}"
                               width="48px">
                           @endif
                       </td>
                       <td>
                           <a href="{{route('categories.restore', $category->id)}}"
                              class="btn btn-primary btn-sm">Restore</a>
                           <form action="{{route('categories.delete-permanent', $category->id)}}"
                                 method="post" class="d-inline" onsubmit="return confirm('Hapus kategori {{ $category->name }} secara permanen?')">
                               @csrf
                               @method('delete')

                               <input type="submit" class="btn btn-danger btn-sm" value="Delete">
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
                       {{$categories->appends(Request::all())->links()}}
                   </td>
               </tr>
               </tfoot>
           </table>
       </div>
    </div>
@endsection
