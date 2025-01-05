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
      'name' => 'සිසුවෙකු එකතු කරන්න',
      'url' => route('add-student-form'),
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
        @endif

        <div class="col-12 mt-4">
            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-1">Students<span class='noto-sans-sinhala-normal'>(සිසුන්)</span></h6>
                    <p class="text-sm"> සිසුන්ගේ පන්ති බැලීම සදහා එක් එක් සිසුවාගේ
                        නමට යටින් ඇති "පන්ති" ඔබන්න</p>
                </div>
                <div class="container mt-5">
                    <div class="row">
                        @foreach ($students as $student)
                            <div class="col-12 mt-3" style="    background-color: #accae1;padding: 18px;margin-bottom: 5px;">
                                <p class="mb-2">
                                    <strong>Name:</strong> <span class="text-primary">{{$student->first_name}} {{$student->last_name}}</span>
                                </p>
                                <p>
                                    <strong>Grade:</strong> <span class="text-primary">{{$student->grade}}</span>
                                </p>
                                <a href="{{route('student-login',$student->id)}}" class="btn btn-primary">පන්ති බලන්න </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>




    </main>



@endsection
