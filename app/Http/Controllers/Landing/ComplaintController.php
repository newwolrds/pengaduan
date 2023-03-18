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
}
