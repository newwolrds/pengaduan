<?php

use App\Models\Complaint;

    function limit_text($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos   = array_keys($words);
            $text  = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }
    function authenticated()
    {
        if(auth()->user()->role == 'admin' || auth()->user()->role == 'user'){
            return redirect()->route('admin_dashboard.index')->with('success', 'Selamat datang '. auth()->user()->name );
        }else{
            return redirect()->route('home')->with('success', 'Selamat datang '. auth()->user()->name );
        }
    }
    function countComplaintPendings()
    {
        return Complaint::where('status', 'PENDING')->count();
    }
    function checkComplaintRespondedUser($complaintId)
    {
        return $complaints = Complaint::where('id', '!=', $complaintId)->where('responded_by', auth()->user()->id)->where('status_pengaduan', 'belum_selesai')->count();
    }
?>