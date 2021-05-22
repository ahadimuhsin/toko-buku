@extends('layouts.global')

@section('title')
    Edit Order
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <form class="shadow-sm bg-white p-3"
            action="{{ route('orders.update', $order->id) }}"
            method="post">

            @csrf
            @method('put')

            <label for="invoice_number">Invoice Number</label><br>
            <input type="text" class="form-control" value="{{ $order->invoice_number }}"
            disabled>
            <br>

            <label for="buyer">Buyer</label><br>
            <input disabled class="form-control" type="text"
            value="{{ $order->user->name }}">
            <br>

            <label for="created_at">Order Date</label><br>
            <input type="text" class="form-control" value="{{ $order->created_at }}" disabled>
            <br>

            <label for="total_qty">Total Quantity</label><br>
            <ul>
                @foreach($order->books as $book)
                <li>{{ $book->title }} <b>({{ $book->pivot->quantity }})</b></li>
                @endforeach
            </ul>
            <br>

            <label for="price">Total Price</label><br>
            <input class="form-control" type="text" value="{{ $order->total_price }}" disabled>
            <br>

            <label for="status">Status</label><br>
            <select class="form-control" name="status" id="status">
                <option {{ $order->status == 'SUBMIT' ? 'selected' : '' }}
                    value="SUBMIT">SUBMIT</option>
                <option {{ $order->status == 'PROCESS' ? 'selected' : '' }}
                    value="PROCESS">PROCESS</option>
                <option {{ $order->status == 'FINISH' ? 'selected' : '' }}
                    value="FINISH">FINISH</option>
                <option {{ $order->status == 'CANCEL' ? 'selected' : '' }}
                    value="CANCEL">CANCEL</option>
            </select>
            <br>

            <input type="submit" class="btn btn-primary" value="Update">
        </div>
    </div>
@endsection
