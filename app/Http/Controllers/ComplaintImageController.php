<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ComplaintImageController extends Controller
{
    public function index($complaintCode)
    {
        $complaint = Complaint::where('code', $complaintCode)->first();
        $complaintImages = ComplaintImage::where('complaint_id', $complaint->id)->orderBy('created_at', 'DESC')->get();
        return view('admin.complaint_image.index', compact('complaint','complaintImages'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'image_description' => 'sometimes|mimes:jpg,jpeg,png,bmp,tiff|max:10000', 
        ]);
        
        if($request->image_description){
            $img = $request->file('image_description');
            $size = $img->getSize();
            $namaImage = time() . "_" . $img->getClientOriginalName();
            Storage::disk('public')->put('galery/'.$namaImage, file_get_contents($img->getRealPath()));
        }
        ComplaintImage::create([
            'complaint_id' => $request->complaint_id,
            'image' => $namaImage,
            'description' => $request->image_description
        ]);
        return redirect()->route('admin.complaint_image.index')->with('success', 'Berhasil ditambahkan');
    }
    
    public function update(Request $request)
    {    
        $this->validate($request, [
            'image_description' => 'sometimes|mimes:jpg,jpeg,png,bmp,tiff|max:10000', 
        ]);
        
        if($request->image_description){
            $img = $request->file('image_description');
            $size = $img->getSize();
            $namaImage = time() . "_" . $img->getClientOriginalName();
            Storage::disk('public')->put('galery/'.$namaImage, file_get_contents($img->getRealPath()));
        }
        $complaintImage = ComplaintImage::where('id', $request->id)->first();
        $complaintImage->update([
            'image' => $namaImage,
            'description' => $request->image_description
        ]);
        return redirect()->route('admin.complaint_image.index')->with('success', 'Berhasil diubah');
    }
    public function delete(Request $request)
    {
        $complaintImage = Complaint::where('id', $request->id)->first();
        $complaintImage->delete();
        return redirect()->route('admin.complaint_image.index')->with('success', 'Berhasil dihapus');
    }
}
