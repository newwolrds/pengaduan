@extends('layouts.admin.master')
@section('content')

<div class="midde_cont">
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title">
                <h2>Dashboard</h2>
                </div>
            </div>
        </div>
        <div class="row column1">
            <div class="col-md-6 col-lg-4">
                <div class="full counter_section margin_bottom_30">
                <div class="couter_icon">
                    <div> 
                        <i class="fa fa-user yellow_color"></i>
                    </div>
                </div>
                <div class="counter_no">
                    <div>
                        <p class="total_no">{{ $users }}</p>
                        <p class="head_couter">Jumlah Pengguna</p>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="full counter_section margin_bottom_30">
                <div class="couter_icon">
                    <div> 
                        <i class="fa fa-clock-o blue1_color"></i>
                    </div>
                </div>
                <div class="counter_no">
                    <div>
                        <p class="total_no">{{ $complaintPendings }}</p>
                        <p class="head_couter">Pengaduan Pending</p>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="full counter_section margin_bottom_30">
                <div class="couter_icon">
                    <div> 
                        <i class="fa fa-cloud-download green_color"></i>
                    </div>
                </div>
                <div class="counter_no">
                    <div>
                        <p class="total_no">{{ $complaints }}</p>
                        <p class="head_couter">Total Pengaduan</p>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    @include('layouts.admin.footer')
</div>
@endsection