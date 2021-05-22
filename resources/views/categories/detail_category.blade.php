@extends('layouts.global')

@section('title')
    Detail Category
@endsection

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <label for="name"><b>Category Name: </b></label>
                <br>
                {{$category->name}}
                <br>

                <label for="slug"><b>Category slug:</b></label><br>
                {{$category->slug}}
                <br>

                <label for="image"><b>Category image:</b></label><br>
                @if($category->image)
                    <img src="{{asset('storage/'.$category->image)}}"
                    width="120px">
                @else
                    <img src="https://www.mhcsa.org.au/wp-content/uploads/2016/08/default-non-user-no-photo.jpg" width="120px">
                @endif
            </div>
        </div>
    </div>
@endsection
