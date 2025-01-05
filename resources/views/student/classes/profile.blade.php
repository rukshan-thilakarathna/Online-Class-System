@extends('layout.app')

{{-- config page --}}
@php
  $navTitle = [
    'en'=>'Classes Profile',
    'si'=>'පන්ති ',
  ];

  $navPath = [ 
        1 => [
        'name' => 'ප්‍රධාන මෙනුව',
        'url' => route('dashboard'),
        ],
        2 => [
        'name' => 'ඔබේ පන්ති',
        'url' => route('classes'),
        ],
    ];
$sidebarStatus = 'classes';
@endphp

@section('style')

<style>
  .profile-section {
    margin: 30px 43px 0;
}
</style>

@endsection

@section('content')

    @include('blocks.aside')

    @php
       $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar',
            4 => 'Apr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Aug', 9 => 'Sep',
            10 => 'Oct', 11 => 'Nov', 12 => 'Dec',
        ];

         // Get the current month number
         $currentMonth = date('n');

        // Rearrange the array to start with the current month while preserving keys
        $months = array_slice($months, $currentMonth - 1, null, true) // Months from current month to December
                + array_slice($months, 0, $currentMonth - 1, true);   // Months from January to the month before the current month
    @endphp



    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      @include('blocks.nav')
      @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


      <div class="col-12 mt-4">
        <div class="col-12 mt-4">
          <div class="card mb-4">
            <div class="card-header pb-0 p-3">
              <h2 class="mb-1">{{$classProfile['class']->name}}</h2>
              <p class="text-sm"> {{$classProfile['class']->description}}</p>

              @if ($classProfile['payment_status'] == 1 || $classProfile['payment_status'] == 2)
                <button class="btn btn-success">Paid for this month <span class="noto-sans-sinhala-normal">(මේ මාසයට ගෙවා ඇත )</span> <span class="badge bg-white text-primary">{{date('F Y')}}</span></button>
                <a href="{{route('payment', $classProfile['class']->id)}}" class="btn btn-primary">Pay for another month <span class="noto-sans-sinhala-normal">(වෙනත් මාසයකට  ගෙවන්න)</span> </a>

              @elseif ($classProfile['payment_status'] == 3)
                <button class="btn btn-">Free Card <span class="noto-sans-sinhala-normal">(නොමිලේ කාඩ්පත)</span> <span class="badge bg-white text-primary">{{date('F Y')}}</span></button>
                <a href="{{route('payment', $classProfile['class']->id)}}" class="btn btn-primary">Pay for another month <span class="noto-sans-sinhala-normal">(වෙනත් මාසයකට  ගෙවන්න)</span> </a>
              @elseif ($classProfile['payment_status'] == 0)
                <a href="{{route('payment', [$classProfile['class']->id,$currentMonth])}}" class="btn btn-primary">Pay This Month <span class="noto-sans-sinhala-normal">(මේ මාසයට ගෙවන්න )</span> <span class="badge bg-white text-primary">{{date('F Y')}}</span></a>
              @endif
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 mt-4">
        <div class="col-12 mt-4">
          <div class="card mb-4">
            <div class="card-header pb-0 ">

              <h6 class="mb-1">Class Time Table</h6>

              @php
                $timeTable = \App\Models\Timetable::where('class_id', $classProfile['class']->id)->first();
                $zoomLink = \App\Models\ZoomLink::first();


                $todayDay = date('l'); // 'l' (lowercase L) returns the full name of the day
              @endphp

                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Class Link</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Day</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Start Time</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">End Time</th>
                    </tr>
                  </thead>
                  <tbody>

                    @if($timeTable->monday != null)
                        @php
                            $classStartTime = $timeTable->monday; // Assuming $timeTable->monday is in 'H:i' format
                            $classEndTime = date('H:i', strtotime($classStartTime . ' + '.$classProfile['class']->class_time_range.' minutes'));
                        @endphp

                      <tr>
                        @if ($todayDay == 'Monday' && (date('H:i') >= $classStartTime && date('H:i') <= $classEndTime))
                          <td>
                            <a target="_blank" href="{{$zoomLink->link}}" class="btn btn-success">Join Class</a>
                          </td>
                        @else
                          <td>-</td>
                        
                        @endif
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">Monday</h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{$classStartTime}}</p>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{$classEndTime}}</p>
                        </td>

                        

                        

                      </tr>
                    @endif
                    @if ($timeTable->tuesday != null)

                    @php
                        $classStartTime = $timeTable->tuesday; // Assuming $timeTable->monday is in 'H:i' format
                        $classEndTime = date('H:i', strtotime($classStartTime . ' + '.$classProfile['class']->class_time_range.' minutes'));
                    @endphp

                      <tr>
                        @if ($todayDay == 'Tuesday' && (date('H:i') >= $classStartTime && date('H:i') <= $classEndTime))
                        <td>
                          <a target="_blank" href="{{$zoomLink->link}}" class="btn btn-success">Join Class</a>
                        </td>
                      @else
                        <td>-</td>
                      
                      @endif
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">Tuesday</h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{$classStartTime}}</p>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{$classEndTime}}</p>
                        </td>

                      </tr> 
                      @endif
                    @if ($timeTable->wednesday != null)

                    @php
                        $classStartTime = $timeTable->wednesday; // Assuming $timeTable->monday is in 'H:i' format
                        $classEndTime = date('H:i', strtotime($classStartTime . ' + '.$classProfile['class']->class_time_range.' minutes'));
                    @endphp

                      <tr>
                        @if ($todayDay == 'Wednesday' && (date('H:i') >= $classStartTime && date('H:i') <= $classEndTime))
                        <td>
                          <a target="_blank" href="{{$zoomLink->link}}" class="btn btn-success">Join Class</a>
                        </td>
                      @else
                        <td>-</td>
                      
                      @endif
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">Wednesday</h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{$classStartTime}}</p>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{$classEndTime}}</p>
                        </td>
                      </tr>
                      @endif
                    @if ($timeTable->thursday != null)

                      @php
                          $classStartTime = $timeTable->thursday; // Assuming $timeTable->monday is in 'H:i' format
                          $classEndTime = date('H:i', strtotime($classStartTime . ' + '.$classProfile['class']->class_time_range.' minutes'));
                      @endphp
                      <tr>
                        @if ($todayDay == 'Thursday' && (date('H:i') >= $classStartTime && date('H:i') <= $classEndTime))
                        <td>
                          <a target="_blank" href="{{$zoomLink->link}}" class="btn btn-success">Join Class</a>
                        </td>
                      @else
                        <td>-</td>
                      
                      @endif
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">Thursday</h6>
                            </div>
                          </div>  
                        </td> 
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{$classStartTime}}</p>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{$classEndTime}}</p>
                        </td>
                      </tr>
                      @endif
                    @if ($timeTable->friday != null)
                      
                    @php
                        $classStartTime = $timeTable->friday; // Assuming $timeTable->monday is in 'H:i' format
                        $classEndTime = date('H:i', strtotime($classStartTime . ' + '.$classProfile['class']->class_time_range.' minutes'));

                    @endphp
                      <tr>
                        @if ($todayDay == 'Friday' && (date('H:i') >= $classStartTime && date('H:i') <= $classEndTime))
                        <td>
                          <a target="_blank" href="{{$zoomLink->link}}" class="btn btn-success">Join Class</a>
                        </td>
                      @else
                        <td>-</td>
                      
                      @endif
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">Friday</h6>
                            </div>  
                          </div>
                        </td> 
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{$classStartTime}}</p>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{$classEndTime}}</p>
                        </td>
                      </tr>
                      @endif
                    @if ($timeTable->saturday != null)

                    @php
                        $classStartTime = $timeTable->saturday; // Assuming $timeTable->monday is in 'H:i' format
                        $classEndTime = date('H:i', strtotime($classStartTime . ' + '.$classProfile['class']->class_time_range.' minutes'));
                    @endphp
                      <tr>
                        @if ($todayDay == 'Saturday' && (date('H:i') >= $classStartTime && date('H:i') <= $classEndTime))
                        <td>
                          <a target="_blank" href="{{$zoomLink->link}}" class="btn btn-success">Join Class</a>
                        </td>
                      @else
                        <td>-</td>
                      
                      @endif
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">Saturday</h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{$classStartTime}}</p>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{$classEndTime}}</p>
                        </td> 
                      </tr>
                      @endif
                    @if ($timeTable->sunday != null)

                    @php
                        $classStartTime = $timeTable->sunday; // Assuming $timeTable->monday is in 'H:i' format
                        $classEndTime = date('H:i', strtotime($classStartTime . ' + '.$classProfile['class']->class_time_range.' minutes'));
                    @endphp
                      <tr>  
                        @if ($todayDay == 'Sunday' && (date('H:i') >= $classStartTime && date('H:i') <= $classEndTime))
                        <td>
                          <a target="_blank" href="{{$zoomLink->link}}" class="btn btn-success">Join Class</a>
                        </td>
                      @else
                        <td>-</td>
                      
                      @endif
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">Sunday</h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{$classStartTime}}</p>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{$classEndTime}}</p>
                        </td> 
                      </tr>
                    @endif
                    

                    


                  </tbody>
                </table>

            </div>
          </div>
        </div>
      </div>



      <div class="col-12 mt-4">
          @include('components.sudent.video-you-are-involved-in')
      </div>

      <div class="col-12 mt-4">
          @include('components.sudent.tute-you-are-involved-in')
      </div>

      <div class="col-12 mt-4">
          @include('components.sudent.test-you-are-involved-in')
      </div>

    </main>



@endsection
