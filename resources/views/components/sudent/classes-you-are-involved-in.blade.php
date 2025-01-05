<div class="col-12 mt-4" style="background: #328b1d;
    padding: 9px;">
    <div class="card mb-4">
      <div class="card-header pb-0 p-3">
        <h6 class="mb-1">Classes you are involved in <span class='noto-sans-sinhala-normal'>(ඔබ සම්බන්ද වී ඇති  පන්ති)</span></h6>
        <p class="text-sm"> Here is a list of classes</p>
      </div>
      <div class="card-body p-3">
        <div class="row " >
            @foreach ($studentClasses as $class )
              @include('components.sudent.class-card', ['isRelated' => false, 'class' => $class])
            @endforeach
        </div>
    </div>
    </div>
  </div>