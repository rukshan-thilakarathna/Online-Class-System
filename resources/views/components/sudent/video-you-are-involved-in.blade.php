<div class="col-12 mt-4">
    <div class="card mb-4">
      <div class="card-header pb-0 p-3">
        <h6 class="mb-1">Videos<span class='noto-sans-sinhala-normal'>(වීඩියෝ)</span> </h6>
        {{-- <button class="btn btn-primary">All Videos <span class="noto-sans-sinhala-normal">(සියලු වීඩියෝ )</span></button> --}}
        {{-- <p class="text-sm"> Here is a list of classes</p> --}}
      </div>
      <div class="card-body p-3">
        <div class="row flex-nowrap overflow-scroll" >
         

          @if ($classProfile['payment_status'] == 0)
          <span class="noto-sans-sinhala-normal" style="background: #c65c5c;color: white;padding: 14px;">මේ මාසය සදහා ගෙවීම් කර ඔබ සදහා වෙන්ව ඇති video නරබන්න </span>
          @else
            @if (count($classProfile['videos']) < 1)
            <span class="noto-sans-sinhala-normal" style="background: #5cc668;color: white;padding: 14px;">පන්තියේ video දැමු පසු ඔබට එය නැරබිය හැක </span>
            @else
              @foreach ($classProfile['videos'] as $video )

                @include('components.sudent.video-card', ['video' => $video])
                
              @endforeach
            @endif
          
          @endif
        </div>
    </div>
    </div>
  </div>