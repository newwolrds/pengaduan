@extends('layouts.admin.master')
@section('title', 'Profile')
@section('content')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.cs"> --}}
<div class="midde_cont">
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title">
                    <h2>Profil</h2>
                </div>
            </div>
        </div>
        <div class="row column1">
           <div class="col-md-2"></div>
           <div class="col-md-8">
              <div class="white_shd full margin_bottom_30">
                 <div class="full graph_head">
                    <div class="heading1 margin_0">
                       <h2>Profil</h2>
                    </div>
                 </div>
                 <div class="full price_table padding_infor_info">
                    <div class="row">
                       <!-- user profile section --> 
                       <!-- profile image -->
                       <div class="col-lg-12">
                          <div class="full dis_flex center_text">
                             <div class="profile_img"><img width="130" height="130" class="rounded-circle" src="{{ auth()->user()->picture ? Storage::disk('local')->url('user/'. auth()->user()->picture) : asset('template/admin-template/images/layout_img/man.png') }}" /></div>
                             <div class="profile_contant">
                                <div class="contact_inner">
                                   <h3>{{ auth()->user()->name }}</h3>
                                   <p><strong>Role: </strong>{{ ucFirst(auth()->user()->role) }}</p>
                                   <ul class="list-unstyled">
                                      <li><i class="fa fa-envelope-o"></i> : {{ auth()->user()->name }}</li>
                                      {{-- <li><i class="fa fa-phone"></i> : 987 654 3210</li> --}}
                                   </ul>
                                </div>
                             </div>
                          </div>
                          <!-- profile contant section -->
                          <div class="full inner_elements margin_top_30">
                             <div class="tab_style2">
                                <div class="tabbar">
                                   <nav>
                                      <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                         <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#recent_activity" role="tab" aria-selected="true">Akun</a>
                                         <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#project_worked" role="tab" aria-selected="false">Ubah Password</a>
                                      </div>
                                   </nav>
                                   <div class="tab-content" id="nav-tabContent">
                                      <div class="tab-pane fade show active" id="recent_activity" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <form action="{{ route('profile.update_account') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="picture">Foto <small>*Isi jika ingin diubah</small></label>
                                                <input type="file" name="picture" id="picture" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Ubah</button>
                                        </form>
                                      </div>
                                      <div class="tab-pane fade" id="project_worked" role="tabpanel" aria-labelledby="nav-profile-tab">
                                        <form action="{{ route('profile.update_password') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="current_password">Password Lama</label>
                                                <input type="password" name="current_password" id="current_password" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="new_password">Password Baru</label>
                                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Ubah</button>
                                        </form>
                                      </div>
                                   </div>
                                </div>
                             </div>
                          </div>
                          <!-- end user profile section -->
                       </div>
                    </div>
                 </div>
              </div>
              <div class="col-md-2"></div>
           </div>
           <!-- end row -->
        </div>
    </div>
    <!-- footer -->
    @include('layouts.admin.footer')
</div>
@endsection