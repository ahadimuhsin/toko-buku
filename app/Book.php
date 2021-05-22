<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    //
    protected $table = 'books';
    // protected $primaryKey = 'id_book';

    protected $fillable =
    [
        "title", "slug", "author", "description", "publisher",
        "cover", "price", "stock", "status", 'weight'
    ];

    //relationship dengan categories
    //many-to-many
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    //relationship dengan orders
    //berbentuk many to many
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
