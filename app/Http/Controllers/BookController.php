<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class BookController extends Controller
{
    //definisi Gate untuk akses menu Books
    public function __construct()
    {
        $this->middleware(function($request, $next){
            if(Gate::allows('manage-books')){
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
        //mengambil kiriman data dari form status
        $status = $request->status;

        //mengambil keyword pencarian dari form
        $keyword = $request->keyword ? $request->keyword : '';

        if($status){
            $books = Book::with('categories')
            ->where('title', 'LIKE', "%$keyword%")
            ->where('status',
            strtoupper($status))->paginate(10);
        }else{
        //mengambil data buku yang berelasi dengan categories
        //per halaman 10
        $books = Book::with('categories')
        ->where('title', 'LIKE', "%$keyword%")
        ->paginate(10);
        }

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //proses validasi data
        Validator::make($request->all(), [
            "title" => "required|min:3|max:200",
            "description" => "required|min:20|max:1000",
            "author" => "required|min:3|max:100",
            "publisher" => "required|min:3|max:200",
            "price" => "required|digits_between:0,10",
            "stock" => "required|digits_between:0,10",
            "cover" => "required|mimes:jpg,jpeg,png,bmp",
            "weight" => "required|numeric|between:0,10.00"
        ])->validate();

        //proses penyimpanan data
        $new_book = new Book();
        $new_book->title =$request->title;
        $new_book->description = $request->description;
        $new_book->author = $request->author;
        $new_book->publisher = $request->publisher;
        $new_book->price = $request->price;
        $new_book->stock = $request->stock;
        $new_book->weight = $request->weight;

        $new_book->status = $request->save_action;

        $cover = $request->file('cover');

        if($cover){
            $cover_path = $cover->store('book-covers', 'public');

            $new_book->cover = $cover_path;
        }

        $new_book->slug = Str::slug($request->title);
        $new_book->created_by = Auth::user()->id;

        $new_book->save();

        /*
        memasukkan id table categories melalui relationship many to many ke
        tabel books
        menangkap request categories dan menyimpannya ke model yang akan dibuat
        attach biasa digunakan saat proses insert
        */

        $new_book->categories()->attach($request->get('categories'));

        if($request->save_action == 'PUBLISH'){
            return redirect()->route('books.index')->with('status',
            'Buku berhasil disimpan dengan status terbit!');
        }
        else{
            return redirect()->route('books.index')->with('status',
            'Buku disimpan dengan status draft!');
        }
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
        $book = Book::findOrFail($id);


        return view('books.edit', compact('book'));
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

        //mengambil data buku berdasarkan id
        $book = Book::findOrFail($id);
        //proses validasi data
        Validator::make($request->all(), [
            "title" => "required|min:3|max:200",
            "slug" => [
                "required",
                Rule::unique("books")->ignore($book->slug, "slug")
            ],
            "description" => "required|min:20|max:1000",
            "author" => "required|min:3|max:100",
            "publisher" => "required|min:3|max:200",
            "price" => "required|digits_between:0,10",
            "stock" => "required|digits_between:0,10",
            "weight" => "required|numeric|between:0,10.00",
            "cover" => "nullable|mimes:jpg,jpeg,png,bmp",
        ])->validate();
        //proses penyimpanan data
        $book->title = $request->title;
        $book->slug = Str::slug($request->slug, '-');
        $book->description = $request->description;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->stock = $request->stock;
        $book->price = $request->price;
        $book->weight = $request->weight;

        $new_cover = $request->file('cover');

        if($new_cover){
            if($book->cover && file_exists(storage_path('app/public/'.$book->cover))){
                Storage::delete('public/'.$book->cover);
            }
            $new_cover_path = $new_cover->store('book-covers', 'public');

            $book->cover = $new_cover_path;
        }

        $book->updated_by = Auth::user()->id;
        $book->status = $request->status;
        $book->save();

        $book->categories()->sync($request->categories);

        return redirect()->route('books.index')->with(['status' =>
        'Buku '.$book->title.' berhasil diperbarui']);
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
        $book = Book::findOrFail($id);

        $book->delete();
        return redirect()->route('books.index')
            ->with(['status' => 'Buku '.$book->title. ' dipindah ke tempat sampah']);
    }

    //method untuk menampilkan buku-buku yang ada di tong sampah
    public function trash()
    {
        $books = Book::onlyTrashed()->paginate(10);

        return view('books.trash', compact('books'));
    }

    //untuk restore buku
    public function restore($id)
    {
        $book = Book::withTrashed()->findOrFail($id);

        //jika buku yang diklik ada di tempat sampah
        //buku tersebut akan direstore
        if($book->trashed()){
            $book->restore();
            return redirect()->route('books.trash')
             ->with(['status' => 'Buku '.$book->title.' sukses direstore']);
        }
        else{ //jika buku tidak ada di tempat sampah
            return redirect()->route('books.trash')
            ->with(['status' => 'Buku '.$book->title.' tidak ada di tempat sampah']);
        }
    }

    //fungsi untuk hapus permanen
    public function deletePermanent($id)
    {
        $book = Book::withTrashed()->findOrFail($id);

        //jika buku tidak ada di tempat sampah
        if(!$book->trashed()){
            return redirect()->route('books.trash')
             ->with(['status' => 'Buku '.$book->title.' tidak ada di tempat sampah!']);
        }else{ //jika ada di tempat sampah
            $book->categories()->detach();
            $book->forceDelete();

            return redirect()->route('books.trash')
             ->with(['status' => 'Buku '.$book->title.' berhasil dihapus permanen!']);
        }
    }
}
