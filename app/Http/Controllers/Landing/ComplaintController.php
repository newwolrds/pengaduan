<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::where('user_id', auth()->user()->id)->get();
        return view('pages.my_complaint.index', compact('complaints'));
    }
    public function update_status(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'status_pengaduan' => 'required',
        ]);
        $complaint = Complaint::find($request->id);
        $complaint->update([
            'status_pengaduan' => $request->status_pengaduan
        ]);
        return redirect()->back()->with('success', 'Status pengaduan diubah');
    }
}
