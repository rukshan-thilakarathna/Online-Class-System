@extends('layout.app')

{{-- config page --}}
@php
  $navTitle = [
    'en'=>'Dashboard',
    'si'=>'ප්‍රධාන මෙනුව',
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

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @include('components.sudent.classes-you-are-involved-in')
        @include('components.sudent.related-classes-section')

      


    </main>



@endsection
