      @php
        $data = json_decode($class, true);
        $okgrade = explode(",", $data['class']['grade']);
        $grades = \App\Models\Grade::get();
                $gradesarray = [];

                foreach ($grades as $grade) {
                    $gradesarray[$grade->id] = $grade->name;
                }

        
      @endphp
      <div class="col-xl-3 col-md-6 mb-4 ">
        <div class="card card-blog card-plain">
          <div class="position-relative">
            <a href="{{route('classes.profile', $data['class']['id'])}}"  class="d-block">
              @php
                $img = $data['class']['image'] == null ? '../img/class.png' : $data['class']['image'];
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
                {{ $data['class']['name'] }}
              </h5>
            </a>
            <p class="mb-4 text-sm">
              {{ $data['class']['description'] }}
            </p>
            <div class="d-flex align-items-center justify-content-between">
              <a href="{{route('classes.profile', $data['class']['id'])}}" type="button" class="btn btn-success w-100  mb-0">@if ($isRelated) Join @else More @endif  <span class='noto-sans-sinhala-normal'>@if ($isRelated) '(ඇතුලත්වන්න)' @else '(ඇතුලට යන්න)' @endif</span></a>
            </div>
          </div>
        </div>
      </div>
