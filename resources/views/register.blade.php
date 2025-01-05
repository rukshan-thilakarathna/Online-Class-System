<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{asset('assets/img/favicon.png')}}">
  <title>
    SimpleEnglish.lk - Register
  </title>
  <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Sinhala:wght@100..900&display=swap" rel="stylesheet">
    <!-- Nucleo Icons -->
    <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('assets/css/soft-ui-dashboard.css?v=ss')}}" rel="stylesheet" />
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>


    <style>
       .active {
        border: 2px solid #0ea5e9 !important;
        background: #fff !important;
        color: #0ea5e9 !important;
        font-weight: bold;
    }

    .show-password{
      font-size: 12px;
    position: absolute;
    right: 6px;
    top: 7px;
    background: #3c3737;
    color: white;
    padding: 4px 6px;
    border-radius: 5px;
    cursor: pointer;
    }
    </style>
</head>

<body class="g-sidenav-show  bg-gray-100">

  
  <main class="main-content  mt-0">
    <section class="min-vh-100 mb-8">
      <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('../assets/img/curved-images/curved14.jpg');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5 text-center mx-auto">
              <h1 class="text-white mb-2 mt-5">Welcome To Simpleenglish.LK</h1>
              <p class="text-lead text-white">Use these awesome forms to login or create new account in your project for free.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10">
          <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
            <div class="card z-index-0">
              
              <div class="card-header text-center pt-4">
                <h5>Register @if ($type == 'student') Student @else Guardian
                  
                @endif</h5>
  
                <div class="text-center row">
                    <a class="btn bg-gradient-info col-6 mr-1 @if ($type == 'student') active @endif" 
                      href="{{ route('register', 'student') }}">
                        Students
                    </a>
                    <a class="btn bg-gradient-info col-6 ml-1 @if ($type == 'guardian') active @endif" 
                      href="{{ route('register', 'guardian') }}">
                        Guardians
                    </a>
                </div>
              </div>
  
              <p class="p-3">ඔබේ එක් දරුවෙකු පමණක් පන්තියට සහභාගී වේ නම් Student , ඔබේ දරුවන් දෙදෙනෙකු හෝ වැඩි ප්‍රමාණයක් පන්තියට සහභාගි වේනම් Guardian යටතේ ලියාපදිංචි වන්න.</p>
  
              <div class="card-body">
               
                <form role="form text-left" action="{{ route('register-post', $type) }}" method="POST">
  
                  
                
                  @csrf
                  <div class="mb-3">
                      <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name" aria-label="First Name" required>
                      @error('first_name')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>
              
                  <div class="mb-3">
                      <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name" aria-label="Last Name" required>
                      @error('last_name')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>
              
                  @if ($type == 'student')
  
                    <div class="mb-3">
                        <select required name="class_type" onchange="classType()" class="form-select @error('class_type') is-invalid @enderror" aria-label="Class Type">
                            <option value="online" {{ old('class_type') == 'online' ? 'selected' : '' }}>Online Class</option>
                            <option value="physical" {{ old('class_type') == 'physical' ? 'selected' : '' }}>Physical Class</option>
                        </select>
                    </div>
  
                    <div class="mb-3">
                        <input type="number" name="grade" min="1" max="11" value="{{ old('grade') }}" class="form-control @error('grade') is-invalid @enderror" placeholder="Grade" aria-label="Grade" required>
                        @error('grade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
  
                    <div class="mb-3" id="student_id" style="display: @if ( old('class_type') == 'physical' ) block @else none @endif">
                        <input type="number" name="student_id" min="1"value="{{ old('student_id') }}" class="form-control @error('student_id') is-invalid @enderror" placeholder="Student ID" aria-label="Stuent ID">
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                  @endif
              
                  <input type="hidden" name="type" value="{{ $type == 'student' ? 'student' : 'guardian' }}">
  
                  @php
                    $countries = \App\Models\Country::all();
                    
                  @endphp
  
                  <div class="mb-3">
                      <select required name="c_code"  class="form-select @error('c_code') is-invalid @enderror" aria-label="Contry" required>
                        @foreach ($countries as $key => $country)
                          <option value="{{ $country->phonecode }}" {{ old('c_code') ?? 94 == $country->phonecode ? 'selected' : '' }}>{{ $country->nicename }}</option>
                        @endforeach
                      </select>
                  </div>
  
                  
              
                  <div class="mb-3">
                      <input autocomplete="false" type="text" name="phone_number" value="{{ old('phone_number') }}" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Phone Number" aria-label="Phone Number" required>
                      @error('phone_number')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>
              
                  <div class="mb-3">
                      <label>Gender</label>
                      <div>
                          <input type="radio" id="male" name="gender" value="0" {{ old('gender') == '0' ? 'checked' : '' }} required>
                          <label for="male">Male</label>
              
                          <input type="radio" id="female" name="gender" value="1" {{ old('gender') == '1' ? 'checked' : '' }} required>
                          <label for="female">Female</label>
                      </div>
                      @error('gender')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>
              
                  <div class="mb-3" style="position: relative">
                    <span class="show-password" onclick="showPassword()">show</span>
                      <input type="password" autocomplete="false" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" aria-label="Password" required>
                      @error('password')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>
              
                  <div class="text-center">
                      <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Register</button>
                  </div>
                  
                  <p class="text-sm mt-3 mb-0">Already have an account? 
                      @if ($type == 'student')
                          <a href="{{ route('login', 'student') }}" class="text-dark font-weight-bolder"> Sign in</a> 
                      @else
                          <a href="{{ route('login', 'guardian') }}" class="text-dark font-weight-bolder">  Sign in</a> 
                      @endif
                  </p>
              </form>
              
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  
  <script>
    function classType() {
        var classType = document.querySelector('select[name="class_type"]').value;
        var studentIdInput = document.getElementById('student_id');
        if (classType === 'online') {
            studentIdInput.style.display = 'none';
        } else {
            studentIdInput.style.display = 'block';
        }
    }
  
    function showPassword() {
        var passwordInput = document.getElementById('password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }
  </script>

 
  <!--   Core JS Files   -->
  <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script src="{{asset('assets/js/plugins/chartjs.min.js')}}"></script>
  <script>
    var ctx = document.getElementById("chart-bars").getContext("2d");

    new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Sales",
          tension: 0.4,
          borderWidth: 0,
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: "#fff",
          data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
          maxBarThickness: 6
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
            },
            ticks: {
              suggestedMin: 0,
              suggestedMax: 500,
              beginAtZero: true,
              padding: 15,
              font: {
                size: 14,
                family: "Inter",
                style: 'normal',
                lineHeight: 2
              },
              color: "#fff"
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false
            },
            ticks: {
              display: false
            },
          },
        },
      },
    });


    var ctx2 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
    gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

    var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

    gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
    gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
    gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

    new Chart(ctx2, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Mobile apps",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#cb0c9f",
            borderWidth: 3,
            backgroundColor: gradientStroke1,
            fill: true,
            data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
            maxBarThickness: 6

          },
          {
            label: "Websites",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#3A416F",
            borderWidth: 3,
            backgroundColor: gradientStroke2,
            fill: true,
            data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
            maxBarThickness: 6
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#b2b9bf',
              font: {
                size: 11,
                family: "Inter",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#b2b9bf',
              padding: 20,
              font: {
                size: 11,
                family: "Inter",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('assets/js/soft-ui-dashboard.min.js?v=1.1.0')}}"></script>
</body>

</html>