<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Order extends Model
{
    //
    protected $fillable =[
        'user_id', 'total_price',
        'invoice_number', 'courier_service',
        'status'
    ];



    //relationship dengan user
    //berbentuk one to many
    //satu order selalu dimiliki oleh user
    //ini yg many
    public function user(){
        return $this->belongsTo(User::class);
    }

    //relationship dengan books yang akan mengambil pivot di kolom quantity
    //berbentuk many-to-many
    public function books()
    {
        return $this->belongsToMany(Book::class)->withPivot('quantity');
    }

    //dynamuc property
    //format dynamic property, depan get, akhirnya Attribute
    //totalQuantity = penjumlahan dari seluruh data quantity di tabel pivot
    //dalam hal ini quantity
    public function getTotalQuantityAttribute()
    {
    $total_qty = 0;

    foreach($this->books as $book){
    $total_qty += $book->pivot->quantity;
    }

    return $total_qty;
    }
}
