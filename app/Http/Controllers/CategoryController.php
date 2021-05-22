<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

    //definisi Gate untuk akses menu Categories
    public function __construct()
    {
        $this->middleware(function($request, $next){
            if(Gate::allows('manage-categories')){
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
        //
        $categories = Category::paginate(10);
        $keyword = $request->name;

        if($keyword){
            $categories= Category::where("name", "LIKE", "%$keyword%")
            ->paginate(10);
        }
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|min:3,max:30',
            'image' => "required|mimes:jpg,jpeg,png,bmp"
        ])->validate();
        //proses penyimpanan data
        $new_category = new Category();
        $new_category->name = $request->name;

        if ($request->file('image')){
            $image_path = $request->file('image')
                ->store('category_images', 'public');
            $new_category->image = $image_path;
        }
        //mengambil data id user yang memasukkan data
        $new_category->created_by = Auth::user()->id;
        //membuat slug dari nama kategori
        $new_category->slug = Str::slug($request->name, '-');

        $new_category->save();


        return redirect()->route('categories.index')
            ->with(['status' => 'Kategori '.$new_category->name.' berhasil disimpan!']);
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
        $category = Category::findOrFail($id);

        return view('categories.detail_category', compact('category'));
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
        $category = Category::findOrFail($id);

        return view('categories.edit', compact('category'));
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

        //proses penyimpanan data
        $name = $request->name;
        $slug = $request->slug;

        $category = Category::findOrFail($id);

        Validator::make($request->all(), [
        'name' => "required|min:3|max:30",
        'image' => "mimes:jpg,jpeg,png,bmp",
        'slug' => [
        "required",
        Rule::unique("categories")->ignore($category->slug, "slug")
            ]
        ])->validate();

        $category->name = $name;
        $category->slug = $slug;

        if($request->file('image')){
            if($category->image && file_exists(storage_path('app/public/'.$category->image))){
                Storage::delete('public/'.$category->image);
            }
            $new_image = $request->file('image')->store('category_images', 'public');

            $category->image = $new_image;
        }
        $category->updated_by = Auth::user()->id;
        $category->slug = Str::slug($name);
        $category->save();

        return redirect()->route('categories.index')
        ->with(['status' => 'Kategori '.$category->name.' berhasil diperbarui']);
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
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')
            ->with(['status' => 'Kategori '.$category->name. ' berhasil dihapus']);
    }

    //untuk melihat kategori apa saja yg sudah dihapus, namun masih
    //bisa direstore
    public function trash()
    {
        $trashed_category = Category::onlyTrashed()->paginate(10);

        return view('categories.trash', ['categories' => $trashed_category]);
    }

    //fungsi untuk mengembalikan kategori yang dihapus menjadi aktif kembali
    public function restore($id)
    {
        //ambil kategori
        $category = Category::withTrashed()->findOrFail($id);

        //cek apakah kategori yang dicari masuk ke kategori trashed
        if($category->trashed()){
            $category->restore();
        }
        else{
            return redirect()->route('categories.index')
                ->with('status', 'Kategori tidak ada di dalam tempat sampah');
        }

        return redirect()->route('categories.index')
            ->with('status', 'Kategori berhasil direstore');
    }

    public function deletePermanent($id)
    {
        $category = Category::withTrashed()->findOrFail($id);

        //jika kategori yang dipilih bukan termasuk softDelete
        if(!$category->trashed()){
            return redirect()->route('categories.index')
                ->with('status', 'Tidak dapat menghapus permanen kategori
                yang aktif');
        }
        else{
            //hapus permanen kategori yang sudah masuk kategori softDelete
            unlink(storage_path('app/public/'.$category->image)); //untuk menghapus file yang berkaitan dengan katgegori terkait
            $category->forceDelete();
            DB::select(DB::raw('ALTER TABLE categories AUTO_INCREMENT = 1'));

            return redirect()->route('categories.index')
                ->with('status', 'Kategori berhasil dihapus secara permanen');
        }
    }

    //fungsi untuk mendapatkan list kategori yg akan ditampilkan
    //di form select2
    public function ajaxSearch(Request $request)
    {
        $keyword = $request->keyword;

        $categories = Category::where('name', 'LIKE', "%$keyword%")->get();

        return $categories;
    }

}
