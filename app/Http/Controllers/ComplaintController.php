<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::orderBy('created_at', 'DESC')->get();
        return view('admin.complaint.index', compact('complaints'));
    }
    public function create()
    {
        return view('admin.complaint.create');
    }
    public function store(Request $request)
    {
        try{
            $this->validate($request, [
                'image_description' => 'sometimes|mimes:jpg,jpeg,png,bmp,tiff|max:10000', 
            ]);
            $length = 5;
            $complaint_code = '';
            for ($i = 0; $i < $length; $i++) {
                $complaint_code .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
            }
            $complaint_code = 'P-'.$complaint_code;
            
            if($request->image_description){
                $img = $request->file('image_description');
                $size = $img->getSize();
                $namaImage = time() . "_" . $img->getClientOriginalName();
                Storage::disk('public')->put('complaint-image/'.$namaImage, file_get_contents($img->getRealPath()));
            }
            DB::beginTransaction();
                $complaint = Complaint::create([
                        'code' => $complaint_code,
                        'user_id' => auth()->user()->id,
                        'title' => $request->title,
                        'date' => Carbon::now()->toDateString(),
                        'description' => $request->description,
                        'level' => 'rendah',
                        'status' => 'PENDING',
                    ]);
                    if($request->image_description){
                        ComplaintImage::create([
                            'complaint_id' => $complaint->id,
                            'image' => $namaImage,
                            'description' => $request->image_description
                        ]);
                    }
            DB::commit();
            if(auth()->user()->role == 'admin'){
                return redirect()->route('complaint.index')->with('success', 'Berhasil ditambahkan');
            }else{
                return redirect()->back()->with('success', 'Pengaduan berhasil dikirim');
            }
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    public function update(Request $request, $code)
    {
        try{
            DB::beginTransaction();
                $complaint = Complaint::where('code', $code)->first();
                $complaint->update([
                        'description' => $request->description,
                        'date' => $request->date,
                        'level' => $request->level,
                        'status' => $request->status,
                    ]);
            DB::commit();
            return redirect()->route('complaint.index')->with('success', 'Berhasil diubah');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function delete(Request $request, $code)
    {
        $complaint = Complaint::where('code', $code)->first();
        $complaint->delete();
        return redirect()->route('complaint.index')->with('success', 'Berhasil dihapus');
    }
}
