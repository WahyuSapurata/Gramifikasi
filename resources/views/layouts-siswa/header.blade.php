 <!-- Navbar -->
 <nav class="navbar navbar-expand navbar-white navbar-light">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <li class="nav-item">
             <a class="nav-link font-weight-bold text-dark h5 m-0" href="#" role="button">{{ $module }}</a>
         </li>
     </ul>

     <!-- Right navbar links -->
     <ul class="navbar-nav ml-auto d-flex align-items-center" style="gap: 5px;">
         <li class="nav-item">
             <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                 <i class="fas fa-expand-arrows-alt"></i>
             </a>
         </li>
         <li class="nav-item">
             <div class="user-panel d-flex align-items-center border border-info rounded-lg">
                 <div class="image pl-0">
                     <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="rounded-lg elevation-2"
                         alt="User Image">
                 </div>
                 <div class="info pr-2">
                     <a href="#" class="d-block text-dark text-capitalize">{{ Auth::user()->nama }}</a>
                 </div>
             </div>
         </li>
         <li class="nav-item">
             <a href="{{ route('logout') }}" class="btn btn-danger  ">
                 <i class="fas fa-sign-out-alt nav-icon"></i>
                 Logout
             </a>
         </li>
     </ul>
 </nav>
 <!-- /.navbar -->
