<div class="col-12 mt-4" style="background: #b3a7d7;
    padding: 10px;">
    <div class="card mb-4">
      <div class="card-header pb-0 p-3">
        <h6 class="mb-1">Related classes <span class='noto-sans-sinhala-normal'>(සම්බන්ද වීය හැකි පන්ති)</span></h6>
        <p class="text-sm"> Here is a list of classes</p>
      </div>
      <div class="card-body p-3">
        <div class="row flex-nowrap overflow-scroll" >

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

                $grades = \App\Models\Grade::get();
                $gradesarray = [];

                foreach ($grades as $grade) {
                    $gradesarray[$grade->id] = $grade->name;
                }


            @endphp

            @foreach ($RelatedClass as $class )
            @php
                $okgrade = explode(",", $class['grade']);
            @endphp
                <div class="col-xl-3 col-md-6 mb-4 ">
                    <div class="card card-blog card-plain">
                        <div class="position-relative">
                            <a class="d-block">
                                @if (session()->get('user')->class_type == 'online')
                                <a href="{{route('payment', [$class['id'],$currentMonth])}}"  class="d-block">
                                @else
                                <a href="{{route('SendRequest', [$class['id'],$currentMonth])}}" class="d-block">
                                @endif

                                @php
                                    $img = $class['image'] == null ? '../assets/img/class.png' :$class['image'];
                                @endphp
                                <img src="{{asset($img)}}" alt="img-blur-shadow" class="img-fluid shadow border-radius-md">
                            </a>
                        </div>
                        <div class="card-body px-1 pb-0">
                            <p class="text-secondary mb-0 text-sm">Grade :
                                @foreach ($okgrade as $grade) 
                                    <span style="color: white;background: #717171;padding: 3px 5px;border-radius: 3px;margin-right: 3px;margin-bottom: 3px;display: inline-block">{{$gradesarray[$grade]}}</span>
                                @endforeach
                            </p>
                            <a href="javascript:;">
                                <h5 class="font-weight-bolder">
                                    {{ $class['name'] }}
                                </h5>
                            </a>
                            <p class="mb-4 text-sm">
                                {{ $class['description'] }}
                            </p>

                            @if (session()->get('user')->class_type == 'online')
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{route('payment', [$class['id'],$currentMonth])}}" type="button" class="btn btn-primary w-100  mb-0">Join  <span class='noto-sans-sinhala-normal'>(ඇතුලත්වන්න)</span></a>
                            </div>
                            @else
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{route('SendRequest', [$class['id'],$currentMonth])}}" type="button" class="btn btn-primary w-100  mb-0">Send Request <span class='noto-sans-sinhala-normal'>(ඉල්ලීම යවන්න)</span></a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
  </div>
