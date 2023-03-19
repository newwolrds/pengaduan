<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintImage;
use App\Models\Response;
use App\Models\ResponseImage;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index');
    }
    public function update_account(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,'. $user->id,
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
            'picture' => $namaPicture ?? $user->picture,
        ]);
        return redirect()->route('profile.index')->with('success', 'Berhasil diubah');
    }
    public function update_password(Request $request)
    {
        $user = User::find(auth()->user()->id);
        if (!(Hash::check($request->get('current_password'), auth()->user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Password lama anda salah.");
        }

        // if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
        //     // Current password and new password same
        //     return redirect()->back()->with("error","New Password cannot be same as your current password.");
        // }

        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'new_password.confirmed' => 'konfirmasi password salah'
        ]);
        $user->password = bcrypt($request->get('new_password'));
        $user->save();
        return redirect()->route('profile.index')->with('success', 'Password brhasil diubah');
    }
}
