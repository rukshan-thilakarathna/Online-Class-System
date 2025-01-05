
      @php
        $data = json_decode($video, true);
        $months = array(
                        1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June",
                        7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December"
                      );
      @endphp
      <div class="col-xl-3 col-md-6">
        <div class="card card-blog card-plain">
          <div class="position-relative">
            <a href=" https://www.youtube.com/embed/{{$data['video']['link']}} "  class="d-block">
              <img src="https://img.youtube.com/vi/{{$data['video']['link']}}/maxresdefault.jpg" alt="img-blur-shadow" class="img-fluid shadow border-radius-md">
            </a>
          </div>
          <div class="card-body px-1 pb-0">
            <p class="text-secondary mb-0 text-sm">Recoded At : {{ $data['video']['recoded_at'] }}</p>
            <a href="javascript:;">
              <h5 class="font-weight-bolder">
                {{$data['video']['title']}}
              </h5>
            </a>
            <p>Month : {{$months[$data['month_number']]}}</p>
            <p class="mb-4 ">
              {{ $data['video']['description'] }}
            </p>
            


            {{-- <div class="d-flex align-items-center">
              <a href=" https://www.youtube.com/embed/{{$data['video']['link']}} "  target="_blank" class="btn btn-primary me-2">View this Video <span class="noto-sans-sinhala-normal">(මෙම වීඩියෝව බලන්න)</span></a>
            </div> --}}
          </div>
        </div>
      </div>
