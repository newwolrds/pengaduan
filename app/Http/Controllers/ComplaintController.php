<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintImage;
use App\Models\Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::orderBy('created_at', 'DESC')
        ->when(request()->q, function($query) {
            $query->where('title', 'like', '%'.request()->q.'%')
            ->orWhere('description', 'like', '%'.request()->q.'%')
            ->orWhereHas('user', function($query) {
                $query->where('name', 'like', '%'.request()->q.'%');
            });
        })
        ->paginate(10);
        $complaints->append(request()->all());
        return view('admin.complaint.index', compact('complaints'));
    }
    public function create()
    {
        return view('admin.complaint.create');
    }
    public function response($code)
    {
        $complaint = Complaint::where('code', $code)->first();
        $responses = Response::where('complaint_id', $complaint->id)->get();
        return view('admin.complaint.make_response', compact('complaint','responses'));
    }
    public function store_response(Request $request)
    {
        $this->validate($request, [
            'file' => 'sometimes|mimes:jpg,jpeg,png,bmp,tiff,pdf,zip,rar|max:120000',
        ]);
        if($request->file){
            $img = $request->file('file');
            $size = $img->getSize();
            $namaFile = time() . "_" . $img->getClientOriginalName();
            Storage::disk('public')->put('response-file/'.$namaFile, file_get_contents($img->getRealPath()));
        }
        Response::create([
            'user_id' => auth()->user()->id,
            'complaint_id' => $request->complaint_id,
            'response' => $request->response,
            'file' => $namaFile ?? null,
        ]);
        return redirect()->back()->with('success', 'Berhasil ditanggapi');
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
                        'level' => $request->level,
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
    public function delete(Request $request)
    {
        $complaint = Complaint::where('code', $request->code)->first();
        $complaint->delete();
        return redirect()->route('complaint.index')->with('success', 'Berhasil dihapus');
    }
    public function change_status(Request $request)
    {
        $complaint = Complaint::where('id', $request->id)->first();
        $complaint->update([
            'status' => $request->status,
        ]);
        return redirect()->back()->with('success', 'Status pengaduan berhasil diubah');
    }
}
