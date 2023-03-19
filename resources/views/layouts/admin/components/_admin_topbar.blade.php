
<div class="topbar">
   <nav class="navbar navbar-expand-lg navbar-light">
       <div class="full">
           <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
           <div class="logo_section">
               <a href="/" class="text-white"><span class="d-flex" style="margin-top: 20px;margin-left:10px;">Lihat Website</span></a>
           </div>
           <div class="right_topbar">
               <div class="icon_info">
               <ul>
                   <li><a href="{{ route('complaint.index') }}"><i class="fa fa-envelope-o"></i><span class="badge">{{ countComplaintPendings() }}</span></a></li>
               </ul>
               <ul class="user_profile_dd">
                   <li>
                       <a class="dropdown-toggle" data-toggle="dropdown"><img width="80" height="30" class="img-responsive rounded-circle" src="{{ auth()->user()->picture ? Storage::disk('local')->url('user/'. auth()->user()->picture) : asset('template/admin-template/images/layout_img/man.png') }}"/><span class="name_user">{{ auth()->user()->name }}</span></a>
                       <div class="dropdown-menu">
                           {{-- <a class="dropdown-item" href="profile.html">My Profile</a>
                           <a class="dropdown-item" href="settings.html">Settings</a>
                           <a class="dropdown-item" href="help.html">Help</a> --}}
                           <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>
                           <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                               @csrf
                           </form>
                       </div>
                   </li>
               </ul>
               </div>
           </div>
       </div>
   </nav>
</div>