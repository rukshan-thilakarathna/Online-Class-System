@extends('layout.app')

{{-- config page --}}
@php
  $navTitle = [
    'en'=>'Payment Page',
    'si'=>'ගෙවීම් පිටුව',
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
  $sidebarStatus = 'dashboard';
@endphp



@section('content')

    @include('blocks.aside')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">


        @include('blocks.nav')

        <form action="{{ route('payment-submit') }}" method="post" enctype="multipart/form-data" class="form-control}}">

            <div class="container-fluid py-4">
                <h2 class="mb-1">Payment Page <span class="noto-sans-sinhala-normal"> (ගෙවීම් පිටුව)</span></h2>
                <h4>Amount : RS {{$amount}}</h4>
                <h4>Account Name : R . M . A . S . K . Rathnayake</h4>

                <div>
                    <img src="{{ asset('img/p-d.png') }}" alt="">
                </div>
                

            </div>
            @csrf
            @php
                $months = [
                     1 => 'January', 2 => 'February', 3 => 'March',
                     4 => 'April', 5 => 'May', 6 => 'June',
                     7 => 'July', 8 => 'August', 9 => 'September',
                     10 => 'October', 11 => 'November', 12 => 'December',
                 ];
            @endphp

            <div class="container-fluid py-4">
                <label for="" class="form-label" style="    font-size: 18px;"> Select month  (මාසය තෝරන්න) </label>

                <div style="display: flex; flex-wrap: wrap">
                    @foreach($months as $key => $month)
                        <div style="display: flex;align-items: center;width: 50%;margin: 5px 0">
                            <label style="    font-size: 15px;width: 100px" for="{{ $month }}" class="form-label"> {{ $month }} </label>
                            <input type="radio" name="month_id" value="{{ $key }}" id="{{ $month }}">
                        </div>
                    @endforeach
                </div>
            </div>

            <input type="hidden" name="class_id" value="{{ $class_id }}">

            <div class="container-fluid py-4">
                <label for="" class="form-label" style="    font-size: 18px;"> Bank Statement (බැංකු ප්රකාශය) </label>
                <input type="file" name="slip" class="form-control" id="" required>
            </div>

            <div class="container-fluid py-4">
                <button type="submit" class="btn btn-primary">Submit (තහවුරු කරන්න)</button>
            </div>

        </form>





    </main>



@endsection
