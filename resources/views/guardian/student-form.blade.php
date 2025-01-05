@extends('layout.app')

{{-- config page --}}
@php
  $navTitle = [
    'en'=>'Add Student',
    'si'=>'ශිෂ්‍යයා එකතු කරන්න',
  ];

  $navPath = [

    1 => [
      'name' => 'ප්‍රධාන මෙනුව',
      'url' => route('dashboard'),
    ],

    2 => [
      'name' => 'සිසුවෙකු එකතු කරන්න',
      'url' => route('add-student-form'),
    ],

];
  $sidebarStatus = 'Add_Student_Form';
@endphp



@section('content')

    @include('blocks.aside')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('blocks.nav')

        <div class="container">
          <h1>Student form  (ශිෂ්‍ය පෝරමය)</h1>
          <form action="{{ route('add-student-store') }}" method="POST" enctype="multipart/form-data">
              @csrf

              {{-- <!-- Type -->
              <div class="mb-3">
                  <label for="type" class="form-label">Type</label>
                  <input type="text" class="form-control" id="type" name="type" value="{{ old('type') }}">
              </div>

              <!-- Student ID -->
              <div class="mb-3">
                  <label for="student_id" class="form-label">Student ID</label>
                  <input type="text" class="form-control" id="student_id" name="student_id" value="{{ old('student_id') }}">
              </div>

              <!-- Class Type -->
              <div class="mb-3">
                  <label for="class_type" class="form-label">Class Type</label>
                  <input type="text" class="form-control" id="class_type" name="class_type" value="{{ old('class_type') }}">
              </div> --}}

              {{-- <!-- Guardian ID -->
              <div class="mb-3">
                  <label for="guardian_id" class="form-label">Guardian ID</label>
                  <input type="text" class="form-control" id="guardian_id" name="guardian_id" value="{{ old('guardian_id') }}">
              </div> --}}
                <div class="mb-3">
                    <label for="grade" class="form-label">Grade (ශ්රේණිය)</label>
                    <select class="form-control" onchange="changeClass(this.value)" id="grade" name="class_type" required>
                    <option value="online" {{ old('class_type') == 'online' ? 'selected' : '' }}>Online Class</option>
                    <option value="physical" {{ old('class_type') == 'physical' ? 'selected' : '' }}>Physical Class</option>
                    </select>
                </div>

                <div class="mb-3" id="student_number_div" style="display:@if(old('class_type') == 'physical') block @else none @endif;">
                    <label for="student_number" class="form-label">Student Number</label>
                    <input type="text" class="form-control" id="student_number" name="student_number" value="{{ old('student_number') }}">
                </div>

              <!-- First Name -->
              <div class="mb-3">
                  <label for="first_name" class="form-label">First Name (මුල් නම)</label>
                  <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
              </div>

              <!-- Last Name -->
              <div class="mb-3">
                  <label for="last_name" class="form-label">Last Name (අවසන් නම)</label>
                  <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
              </div>

              {{-- <!-- Email -->
              <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
              </div> --}}

              {{-- <!-- Phone Number -->
              <div class="mb-3">
                  <label for="phone_number" class="form-label">Phone Number</label>
                  <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
              </div>

              <!-- Password -->
              <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password">
              </div>
       --}}
              <!-- Grade -->
              <div class="mb-3">
                  <label for="grade" class="form-label">Grade (ශ්රේණිය)</label>
                  <select class="form-control" id="grade" name="grade" required>
                    <option value="1" {{ old('grade') == '1' ? 'selected' : '' }}>1</option>
                    <option value="2" {{ old('grade') == '2' ? 'selected' : '' }}>2</option>
                    <option value="3" {{ old('grade') == '3' ? 'selected' : '' }}>3</option>
                    <option value="4" {{ old('grade') == '4' ? 'selected' : '' }}>4</option>
                    <option value="5" {{ old('grade') == '5' ? 'selected' : '' }}>5</option>
                    <option value="6" {{ old('grade') == '6' ? 'selected' : '' }}>6</option>
                    <option value="7" {{ old('grade') == '7' ? 'selected' : '' }}>7</option>
                    <option value="8" {{ old('grade') == '8' ? 'selected' : '' }}>8</option>
                    <option value="9" {{ old('grade') == '9' ? 'selected' : '' }}>9</option>
                    <option value="10" {{ old('grade') == '10' ? 'selected' : '' }}>10</option>
                    <option value="11" {{ old('grade') == '11' ? 'selected' : '' }}>11</option>

                </select>
              </div>

              {{-- <!-- WhatsApp Number -->
              <div class="mb-3">
                  <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                  <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number') }}">
              </div>

              <!-- Image -->
              <div class="mb-3">
                  <label for="image" class="form-label">Image</label>
                  <input type="file" class="form-control" id="image" name="image">
              </div>

              <!-- Address -->
              <div class="mb-3">
                  <label for="address" class="form-label">Address</label>
                  <textarea class="form-control" id="address" name="address">{{ old('address') }}</textarea>
              </div>
       --}}
              <!-- Birthday -->
              <div class="mb-3">
                  <label for="birthday" class="form-label">Birthday (උපන් දිනය)</label>
                  <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') }}" required>
              </div>

              <!-- Gender -->
              <div class="mb-3">
                  <label for="gender" class="form-label">Gender (ලිංගභේදය)</label>
                  <select class="form-control" id="gender" name="gender" required>
                      <option value="0" {{ old('gender') == '0' ? 'selected' : '' }}>Male</option>
                      <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>Female</option>
                  </select>
              </div>

              {{-- <!-- Status -->
              <div class="mb-3">
                  <label for="status" class="form-label">Status</label>
                  <select class="form-control" id="status" name="status">
                      <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                      <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                  </select>
              </div> --}}

              <!-- Submit Button -->
              <button type="submit" class="btn btn-primary">Submit</button>
          </form>
      </div>


    </main>

    <script>
        function changeClass(x) {
            
            
            
            var div = document.getElementById('student_number_div');
            var input = document.getElementById('student_number');
            switch (x) {
                case 'physical':
                    div.style.display = 'block';
                    input.required = true;
                    break;
                case 'online':
                    div.style.display = 'none';
                    input.required = false;
                    break;
            }

           
            

            // if(x == 'physical'){
            //     console.log(x);
                
            //     // div.style.display = 'block';
            //     // input.required = true;
            // }elseif(x == 'online'){
            //     div.style.display = 'none';
            //     input.required = false;
            // }
            
        }
     </script>

@endsection
