<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{

    //definisi Gate untuk akses menu Books
    public function __construct()
    {
        $this->middleware(function($request, $next){
            if(Gate::allows('manage-orders')){
                return $next($request);
            }
            abort (403, "Anda Tidak Memiliki Akses Melakukan Ini");
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->status;
        $buyer_email = $request->buyer_email;

        //menampilkan data order yang memiliki user dan books
        //dan menampilkan hasil pencarian berdasarkan email dan status
        $orders = Order::with('user')
        ->with('books')
        ->whereHas('user', function($query) use ($buyer_email){
            $query->where('email', 'LIKE', "%$buyer_email%");
        })
        ->where('status', 'LIKE', "%$status%")
        ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $order = Order::findOrFail($id);

        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $order = Order::findOrFail($id);

        $order->status = $request->status;

        $order->save();

        return redirect()->route('orders.index')
        ->with(['status' => 'Order '.$order->invoice_number.' berhasil diperbarui statusnya']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
