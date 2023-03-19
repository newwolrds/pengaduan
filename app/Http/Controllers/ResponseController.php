<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintImage;
use App\Models\Response;
use App\Models\ResponseImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ResponseController extends Controller
{
    public function index($code)
    {
        $complaint = Complaint::where('code', $code)->first();
        $response = Response::where('complaint_id', $complaint->id)->first();
        $responseImages = ResponseImage::where('response_id', $response->id)->get();
        return view('admin.response.index', compact('complaint','response','responseImages'));
    }
    public function store(Request $request)
    {
        Response::create([
            'user_id' => auth()->user()->id,
            'complaint_id' => $request->complaint_id,
            'response' => $request->response,
        ]);
        return redirect()->route('admin.response.index')->with('success', 'Berhasil diubah');
    }
    public function update(Request $request, $responseId)
    {
        $response = Response::find($request->responseId);
        $response->update([
            'response' => $request->response,
        ]);
        return redirect()->route('admin.response.index')->with('success', 'Berhasil diubah');
    }
    public function delete(Request $request)
    {
        $response = Response::find($request->id);
        $response->delete();
        return redirect()->back()->with('success', 'Berhasil dihapus');
    }
}
