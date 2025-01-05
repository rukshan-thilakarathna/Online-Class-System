    
    @if (session()->get('user')->type == 0)
      <!-- Navbar -->
      <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
              <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">System</a></li>

              @foreach ($navPath  as  $path )
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page"><a class="opacity-5 text-dark" href="{{$path['url']}}">{{$path['name']}}</a></li>
              @endforeach

            </ol>
            <h6 class="font-weight-bolder mb-0">{{$navTitle['en']}}<span class='noto-sans-sinhala-normal'>({{$navTitle['si']}})</span></h6>
          </nav>
          <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
              {{-- <div class="input-group">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control" placeholder="Type here...">
              </div> --}}
            </div>
            <ul class="navbar-nav  justify-content-end">
              <li class="nav-item d-flex align-items-center">
                <a class="btn btn-outline-primary btn-sm mb-0 me-3" >Grade {{session()->get('user')->grade}}</a>
              </li>
              
              <li class="nav-item d-flex align-items-center">
                <a class="btn btn-outline-primary btn-sm mb-0 me-3" > {{session()->get('user')->class_type}} Class Student</a>
              </li>

              <li class="nav-item d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                  <i class="fa fa-user me-sm-1"></i>
                  <span class="d-sm-inline d-none">{{session()->get('user')->first_name}} {{session()->get('user')->last_name}} - {{session()->get('user')->student_id}}</span>
                </a>
              </li> 

              <li class="nav-item  ps-3 d-flex align-items-center">
                  <a href="{{route('logout')}}" class="nav-link text-body font-weight-bold px-0">
                      <i class="fa fa-power-off me-sm-1"></i>
                      <span class="d-sm-inline d-none">LogOut <span class="noto-sans-sinhala-normal">(පිටවීම)</span></span>
                  </a>
              </li>

              <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                  <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                  </div>
                </a>
              </li>
              
            </ul>
          </div>
        </div>
      </nav>

    @else

      <!-- Navbar -->
      <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
              <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">System</a></li>

              @foreach ($navPath  as  $path )
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page"><a class="opacity-5 text-dark" href="{{$path['url']}}">{{$path['name']}}</a></li>
              @endforeach

            </ol>
            <h6 class="font-weight-bolder mb-0">{{$navTitle['en']}}<span class='noto-sans-sinhala-normal'>({{$navTitle['si']}})</span></h6>
          </nav>
          <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
              {{-- <div class="input-group">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control" placeholder="Type here...">
              </div> --}}
            </div>
            <ul class="navbar-nav  justify-content-end">
              {{-- <li class="nav-item d-flex align-items-center">
                <a class="btn btn-outline-primary btn-sm mb-0 me-3" >Grade {{session()->get('user')->grade}}</a>
              </li> --}}
              <li class="nav-item d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                  <i class="fa fa-user me-sm-1"></i>
                  <span class="d-sm-inline d-none">{{session()->get('user')->first_name}} {{session()->get('user')->last_name}} - {{session()->get('user')->student_id}}</span>
                </a>
              </li> 

              <li class="nav-item  ps-3 d-flex align-items-center">
                  <a href="{{route('logout')}}" class="nav-link text-body font-weight-bold px-0">
                      <i class="fa fa-power-off me-sm-1"></i>
                      <span class="d-sm-inline d-none">LogOut <span class="noto-sans-sinhala-normal">(පිටවීම)</span></span>
                  </a>
              </li>

              <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                  <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                  </div>
                </a>
              </li>
              
            </ul>
          </div>
        </div>
      </nav>
    @endif
    