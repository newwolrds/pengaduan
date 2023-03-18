<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $complaints = Complaint::count();
        $complaintPendings = Complaint::where('status', 'PENDING')->count();
        $complaintDones = Complaint::where('status', 'DONE')->count();
        $complaintRejecteds = Complaint::where('status', 'REJECTED')->count();
        return view('admin.dashboard.index', compact('complaints','complaintPendings','complaintDones','complaintRejecteds'));
    }
}
