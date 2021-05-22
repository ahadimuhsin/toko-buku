<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
class UserController extends Controller
{
    //definisi Gate untuk akses menu User
    public function __construct()
    {
    $this->middleware(function($request, $next){
        if(Gate::allows('manage-users')){
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

        $filter_keyword = $request->keyword;
        $status = $request->get('status');

        if ($filter_keyword and $status){
            $users = User::where('email', 'LIKE ', "%$filter_keyword%")
            ->where('status', $status)
            ->paginate(10);
        }
        else if ($filter_keyword){
            $users = User::where('email', 'LIKE', "%$filter_keyword%")
            ->paginate(10);
        }
        else if ($status){
            $users = User::where('status', $status)->paginate(10);
        }
        else{
            $users = User::paginate(10);
        }

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("users.create");
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
            "name" => "required|min:5|max:100",
            "username" => "required|unique:users|min:5|max:20",
            "roles" => "required",
            "phone" => "required|digits_between:10,12",
            "address" => "required|min:8|max:200",
            "avatar" => "required|mimes:jpeg,jpg,png,bmp",
            "email" => "required|email|unique:users",
            "password" => "required",
            "password_confirmation" => "required|same:password"
        ])->validate();

        //proses penyimpanan data
        $new_user = new User();
        $new_user->name = $request->name;
        $new_user->username = $request->username;
        $new_user->roles = json_encode($request->roles);
        $new_user->address = $request->address;
        $new_user->phone = $request->phone;
        $new_user->email = $request->email;
        $new_user->password = Hash::make($request->password);

        //handle file upload
        if($request->file('avatar')){
            $file = $request->file('avatar')->store('avatars', 'public');

            $new_user->avatar = $file;
        }

        $new_user->save();

        return redirect()->route('users.index')
        ->with(['status' => 'User '.$new_user->name.' berhasil ditambahkan']);
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
        $user = User::findOrFail($id);

        return view('users.show_detail', compact('user'));
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
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
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
        //proses validasi data
        Validator::make($request->all(), [
            "name" => "required|min:5|max:100",
            "roles" => "required",
            "phone" => "required|digits_between:10,12",
            "address" => "required|min:8|max:200",
            // "avatar" => "required|mimes:jpeg,jpg,png,bmp",
        ])->validate();
        //prose penyimpanan data yg diupdate
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->roles = json_encode($request->roles);
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->status = $request->status;

        if($request->file('avatar')){
            //jika field upload file tidak kosong, lakukan pengecekan terlebih dahulu
            //apakah user yang diedit ini memiliki file avatar di server, jika ada
            //hapus file lamanya
            if($user->avatar && file_exists(storage_path('app/public/'.$user->avatar))){
                Storage::delete('public/'.$user->avatar);
            }
            $file = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $file;
        }

        $user->save();

        return redirect()->route('users.index', [$id])
            ->with(['status' => 'Data '.$user->name.' berhasil diperbarui']);
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
        $user = User::findOrFail($id);
//        $file_path = app_path("public/storage/".$user->avatar);

//        if(file_exists($file_path)){
//            File::delete($file_path);
//        }
//        Storage::disk('public')->delete('storage/'.$user->avatar);
        // File::delete('storage/'.$user->avatar);
        // DB::select(DB::raw('ALTER TABLE users AUTO_INCREMENT = 1'));
        if(storage_path('app/public/'.$user->avatar)){
            unlink(storage_path('app/public/'.$user->avatar)); //menghapus file avatar user terkait
        }

        $user->delete();
        
        return redirect(route('users.index'))->with(['status' => 'User ' .$user->name. ' berhasil dihapus']);
    }
}
