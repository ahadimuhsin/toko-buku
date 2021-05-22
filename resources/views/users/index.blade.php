@extends('layouts.global')

@section('title')
    List User
@endsection

@section('pageTitle')
    Daftar User
@endsection

@section('content')
    <div class="col-md-12">
         @if(session('status'))
             <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session('status')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        {{-- Filter User berdasarkan email  --}}
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('users.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <input value="{{ Request::get('keyword') }}"
                            name="keyword"
                            class="form-control"
                            type="text"
                            placeholder="Filter berdasarkan email"
                            value="{{ old('keyword') }}">
                        </div>
                        <div class="col-md-8">

                            <input {{ Request::get('status') == 'ACTIVE' ? 'checked' : '' }}
                            value="ACTIVE" name="status" type="radio" class="form-control"
                            id="active">
                            <label for="active">Active</label>

                            <input {{ Request::get('status') == 'NONACTIVE' ? 'checked' : '' }}
                            value="NONACTIVE" name="status" type="radio" class="form-control"
                            id="nonactive">
                            <label for="nonactive">Nonactive</label>

                            <input type="submit" value="Filter" class="btn btn-primary">

                            <a href="{{ route('users.create') }}" class="btn btn-outline-primary"
                            style="float: right;">
                            <i class="oi oi-plus"></i>Tambah Data User</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <hr class="my-3">
        {{-- <div class="row"> --}}
            {{-- <div class="col-md-12"> --}}

                {{-- Tombol Tambah User --}}
                {{-- <a href="{{ route('users.create') }}" class="btn btn-outline-primary"
                style="float: right;">
                <i class="oi oi-plus"></i>Tambah Data User</a> --}}

            {{-- </div> --}}
        {{-- </div> --}}
        {{-- Akhor dari form filter --}}

        {{-- Tabel --}}
        <table class="table table-bordered" style="margin-top: 20px;">
            <thead>
            <tr>
                <th><b>Name</b></th>
                <th><b>Username</b></th>
                <th><b>Email</b></th>
                <th><b>Avatar</b></th>
                <th><b>Status</b></th>
                <th><b>Action</b></th>

            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->email}}</td>
                    <td align="center">
                        @if($user->avatar)
                            <img src="{{asset('public/storage/'.$user->avatar)}}" width="70px">
                        @else
                            <img src="https://www.mhcsa.org.au/wp-content/uploads/2016/08/default-non-user-no-photo.jpg"
                    width="70px">
                        @endif
                    </td>
                    <td align="center">
                        @if($user->status=="ACTIVE")
                        <span class="badge badge-success">
                            {{ $user->status }}
                        </span>
                        @else
                        <span class="badge badge-danger">
                            {{ $user->status }}
                        </span>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-info text-white btn-sm"
                        href="{{route('users.edit', $user->id)}}"><i class="oi oi-pencil"></i>Edit</a>
                        <form
                            onsubmit="return confirm('Yakin hapus user {{ $user->name }} secara permanen?')"
                            class="d-inline"
                            action="{{route('users.destroy', $user->id)}}"
                            method="post">

                            @csrf
                            @method('delete')

                            <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary btn-sm">
                                <i class="oi oi-book"></i>Detail
                            </a>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Data Kosong</td>
                </tr>
            @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10">
                        {{ $users->appends(Request::all())->links() }}
                    </td>
                </tr>
            </tfoot>
        </table>
        {{-- Akhir Tabel --}}
    </div>
@endsection
