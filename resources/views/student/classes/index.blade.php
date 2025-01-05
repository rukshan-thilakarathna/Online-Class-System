@extends('layout.app')

{{-- config page --}}
@php
  $navTitle = [
    'en'=>'Classes',
    'si'=>'පන්ති',
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
$sidebarStatus = 'classes';
@endphp

@section('content')

    @include('blocks.aside')



    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('blocks.nav')

        <div class="col-12 mt-4">
            @include('components.sudent.classes-you-are-involved-in')
        </div>
    </main>


   
@endsection