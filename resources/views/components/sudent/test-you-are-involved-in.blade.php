<div class="col-12 mt-4">
    <div class="card mb-4">
      <div class="card-header pb-0 p-3">
        <h6 class="mb-1">Online Papers<span class='noto-sans-sinhala-normal'>(පරීක්ෂණය)</span> </h6>
        {{-- <button class="btn btn-primary">All Tests <span class="noto-sans-sinhala-normal">(සියලු පරීක්ෂණය )</span></button> --}}
        {{-- <p class="text-sm"> Here is a list of classes</p> --}}
      </div>
      <div class="card-body p-3">
        <div class="row flex-nowrap overflow-scroll" >

         

          @if ($classProfile['payment_status'] == 0)
            <span class="noto-sans-sinhala-normal" style="background: #c65c5c;color: white;padding: 14px;">මේ මාසය සදහා ගෙවීම් කර ඔබ සදහා වෙන්ව ඇති Online Papers කරන්න  </span>
          @else
            @if (count($classProfile['tests']) < 1)
            <span class="noto-sans-sinhala-normal" style="background: #5cc668;color: white;padding: 14px;">පන්තියේ Online Papers දැමු පසු ඔබට එය කිරීමට හැක </span>
            @else
              @foreach ($classProfile['tests'] as $test )
                @include('components.sudent.test-card', ['test' => $test])
              @endforeach
            @endif
           
          @endif

         
        </div>
    </div>
    </div>
  </div>