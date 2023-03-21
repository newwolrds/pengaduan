<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintImage;
use App\Models\Response;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;
class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = $this->indexs()->paginate(10);
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
        if(checkComplaintRespondedUser($complaint->id) > 0){
            return redirect()->back()->with('error', 'Anda belum dapat menanggapi pengaduan ini dikarenakan masih terdapat status pengaduan yang belum selesai pada pengaduan yang lain');
        }
        $responses = Response::where('complaint_id', $complaint->id)->get();
        return view('admin.complaint.make_response', compact('complaint','responses'));
    }
    public function store_response(Request $request)
    {
        if(checkComplaintRespondedUser($request->complaint_id) > 0){
            return redirect()->back()->with('error', 'Anda belum dapat menanggapi pengaduan ini dikarenakan masih terdapat status pengaduan yang belum selesai pada pengaduan yang lain');
        }
        $this->validate($request, [
            'file' => 'sometimes|mimes:jpg,jpeg,png|max:120000',
        ]);
        try {
            DB::beginTransaction();
                if($request->file){
                    $img = $request->file('file');
                    $size = $img->getSize();
                    $namaFile = time() . "_" . $img->getClientOriginalName();
                    Storage::disk('public')->put('response-file/'.$namaFile, file_get_contents($img->getRealPath()));
                }
                $complaint = Complaint::find($request->complaint_id);
                $complaint->update([
                    'responded_by' => auth()->user()->id,
                    'status' => 'done',
                ]);
                Response::create([
                    'user_id' => auth()->user()->id,
                    'complaint_id' => $request->complaint_id,
                    'response' => $request->response,
                    'file' => $namaFile ?? null,
                ]);
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil ditanggapi');
        }catch(Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    public function store(Request $request)
    {
        try{
            $this->validate($request, [
                'description' => 'required',
                'link_video' => 'required',
                'level' => 'required',
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
                        'link_video' => $request->link_video,
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
                return redirect()->route('landing.my_complaint.index')->with('success', 'Pengaduan berhasil dikirim');
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
    public function export_pdf(Request $request)
    {
        $complaints = $this->indexs()->get();
        $filter = request()->filter;
        $from = request()->from;
        $to = request()->to;

        if($filter == 'mingguan'){
            $periode = Carbon::now()->startOfWeek()->toDateString() . ' - ' . Carbon::now()->endOfWeek()->toDateString();
        }else if($filter == 'bulanan'){
            $periode = date("F", mktime(0, 0, 0, Carbon::now()->month, 1)) . ' - ' . Carbon::now()->year;
        }else if($filter == 'tahunan'){
            $periode = Carbon::now()->year;
        }else {
            $periode = '';
        }
        // return view('admin.complaint.export_pdf', compact('complaints'));
        $customPaper = array(0,0,2000.00,900.80);

    	$pdf = PDF::loadview('admin.complaint.export_pdf', compact('complaints','filter','from','to','periode'))->setPaper($customPaper, 'landscape');;
    	return $pdf->download('laporan-pengaduan-pdf.pdf');
    }

    public function indexs()
    {
        $role = auth()->user()->role;
        return  Complaint::orderBy('created_at', 'DESC')
        ->when($role == 'user', function($query) {
            $query->whereNull('responded_by')->orWhere('responded_by', auth()->user()->id);
        })
        // ->when($role == 'user', function($query) {
        //     $query->where('responded_by', auth()->user()->id)->where('status_pengaduan', 'belum_selesai')
        // })
        ->when(request()->q, function($query) {
            $query->where('title', 'like', '%'.request()->q.'%')
            ->orWhere('description', 'like', '%'.request()->q.'%')
            ->orWhereHas('user', function($query) {
                $query->where('name', 'like', '%'.request()->q.'%');
            });
        })
        ->when(request()->filter, function($query) {
            if(request()->filter == 'mingguan'){
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            }else if(request()->filter == 'bulanan'){
                $query->whereMonth('created_at', Carbon::now()->month);
            }else if(request()->filter == 'tahunan'){
                $query->whereYear('created_at', Carbon::now()->year);
            }
        })
        ->when(request()->from, function ($query) {
            return $query->whereDate('created_at', '>=', request()->from);
        })
        ->when(request()->to, function ($query) {
            return $query->whereDate('created_at', '<=', request()->to);
        });
    }
}
