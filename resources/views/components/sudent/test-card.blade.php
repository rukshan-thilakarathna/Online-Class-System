      @php
        $data = json_decode($test, true);

        $isTestComplete = \App\Models\StudentHasTest::where('student_id', Session()->get('user_id'))
                  ->where('test_id', $data['test']['id'])
                  ->exists();
        $result = \App\Models\StudentHasTest::where('student_id', Session()->get('user_id'))
                  ->where('test_id', $data['test']['id'])
                  ->first();


        $months = array(
              1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June",
              7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December"
            );


      @endphp
      <div class="col-xl-3 col-md-6" style="margin: 0 10px;@if ($isTestComplete)
        background: #a3ffdd;
        @else
        background: #ffcaa3;
      @endif">
        <div class="card card-blog card-plain">
          <div class="position-relative">
            
              @if ($isTestComplete)
              <a href="{{ route('classes.test.result', $data['test']['id']) }}" class="d-block">

              @else
              <a href="{{ route('classes.test', [$data['test']['id'], $classProfile['class']->id]) }}" class="d-block">
          

            @endif
              <img src="{{asset('assets/img/test.png')}}" alt="img-blur-shadow" class="img-fluid shadow border-radius-md">
            </a>
          </div>
          <div class="card-body px-1 pb-0">
            <p class="text-secondary mb-0 text-sm">{{ $data['test']['test_type']['name'] }}</p>
            <a href="javascript:;">
              <h5 class="font-weight-bolder">
                {{$data['test']['name']}}
              </h5>
            </a>
            <p class="mb-4 ">
              {{$data['test']['description']}}
            </p>
            @if (!$isTestComplete)
              <p>Month : {{$months[$data['month_number']]}}</p>
              <p>Test Time : {{$data['test']['test_time']}} min</p>
              <p>Full Marks : {{$data['test']['marks']}}</p>
            @else
              <p>Month : {{$months[$data['month_number']]}}</p>
              <p>Test Time : {{$data['test']['test_time']}} min</p>
              <p>Full Marks : {{$data['test']['marks']}}</p>
              <p>Get Marks : {{$result->get_marks}}</p>
              <p>Pracntage : {{$result->marks_percentage}}%</p>
              <p>Rank : {{$result->status}}%</p>
            @endif

            <div class="d-flex align-items-center">

              @if ($isTestComplete)

                <button class="btn btn-success me-2 w-50">Completed</button>
                <a href="{{ route('classes.test.result', $data['test']['id']) }}" class="btn btn-primary me-2 w-50"> Show correction </a>

                @else

                <a href="{{ route('classes.test', [$data['test']['id'], $classProfile['class']->id]) }}" class="btn btn-primary me-2 w-100">Start Test</a>

              @endif

            </div>


          </div>
        </div>
      </div>
