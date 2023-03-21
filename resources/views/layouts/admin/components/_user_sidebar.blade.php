
<nav id="sidebar">
    <div class="sidebar_blog_1">
       <div class="sidebar-header">
          <div class="logo_section">
             <a href="/"><img class="logo_icon img-responsive" src="{{ asset('template/admin-template/images/logo/logo_icon.png') }}" alt="#" /></a>
          </div>
       </div>
       <div class="sidebar_user_info">
          <div class="icon_setting"></div>
          <div class="user_profle_side">
             <div class="user_img"><img width="80" height="80" class="img-responsive" src="{{ auth()->user()->picture ? Storage::disk('local')->url('user/'. auth()->user()->picture) : asset('template/admin-template/images/layout_img/man.png') }}"/></div>
             <div class="user_info">
                <h6>{{ auth()->user()->name }}</h6>
                <p><span class="online_animation"></span> Online</p>
             </div>
          </div>
       </div>
    </div>
    <div class="sidebar_blog_2">
       <h4>Menu Pengaduan</h4>
       <ul class="list-unstyled components">
          <li><a href="{{ route('admin_dashboard.index') }}"><i class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span></a></li>
          <li><a href="{{ route('complaint.index') }}"><i class="fa fa-paper-plane red_color"></i> <span>Pengaduan</span></a></li>
          <li><a href="{{ route('profile.index') }}"><i class="fa fa-wrench blue_color"></i> <span>Profil</span></a></li>
          <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out blue_color"></i> <span>Logout</span></a></li>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
       </ul>
    </div>
 </nav>