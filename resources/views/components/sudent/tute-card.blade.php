       @php
        $data = json_decode($tute, true);
        $months = array(
                        1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June",
                        7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December"
                      );
      @endphp
     <div class="col-xl-3 col-md-6">

        <div class="card card-blog card-plain">

          <div class="position-relative">
            <a href="{{ asset('storage/' . $data['tute']['pdf']) }}" class="d-block">
              <img src="{{asset('assets/img/tute.png')}}" alt="img-blur-shadow" class="img-fluid shadow border-radius-md">
            </a>
          </div>

          <div class="card-body px-1 pb-0">

            <a href="javascript:;">
              <h5 class="font-weight-bolder">
                {{$data['tute']['title']}}
              </h5>
            </a>
            <p>Month : {{$months[$data['month_number']]}}</p>

            <p class="mb-4 ">
              {{$data['tute']['description']}}
            </p>

            <div class="d-flex align-items-center">
              <a href="{{ asset($data['tute']['pdf']) }}" class="btn btn-primary me-2">View</a>
            </div>

          </div>

        </div>

      </div>
