<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    //
    use SoftDeletes;
    // protected $primaryKey = "id_category";

    protected $fillable = [
        "name", "slug", "image", "created_at", "updated_at",
        "created_by", "updated_by", "deleted_at", "deleted_by"
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
