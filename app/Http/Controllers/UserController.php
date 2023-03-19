<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintImage;
use App\Models\Response;
use App\Models\ResponseImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::when(request()->q, function($query) {
            $query->where('name', 'like', '%'.request()->q.'%')->orWhere('email', 'like', '%'.request()->q.'%')->orWhere('role', 'like', '%'.request()->q.'%');
        })->get();
        return view('admin.user.index', compact('users'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'role' => 'required',
            'picture' => 'sometimes|mimes:jpg,jpeg,png,bmp,tiff|max:10000', 
        ]);
        if($request->picture){
            $img = $request->file('picture');
            $size = $img->getSize();
            $namaPicture = time() . "_" . $img->getClientOriginalName();
            Storage::disk('public')->put('user/'.$namaPicture, file_get_contents($img->getRealPath()));
        }
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'is_active' => '1',
            'picture' => $namaPicture,
        ]);
        return redirect()->route('user.index')->with('success', 'Berhasil diubah');
    }
    public function update(Request $request)
    {
        $user = User::find($request->id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,'. $user->id,
            'password' => 'sometimes',
            'role' => 'required',
            'picture' => 'sometimes|mimes:jpg,jpeg,png,bmp,tiff|max:10000', 
        ]);
        if($request->picture){
            $img = $request->file('picture');
            $size = $img->getSize();
            $namaPicture = time() . "_" . $img->getClientOriginalName();
            Storage::disk('public')->put('user/'.$namaPicture, file_get_contents($img->getRealPath()));
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'role' => $request->role,
            'is_active' => '1',
            'picture' => $namaPicture ?? $user->picture,
        ]);
        return redirect()->route('user.index')->with('success', 'Berhasil diubah');
    }
    public function delete(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
        return redirect()->back()->with('success', 'Berhasil dihapus');
    }
}
