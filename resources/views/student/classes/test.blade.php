@extends('layout.app')

{{-- config page --}}
@php
  $navTitle = [
    'en'=>'Classes Profile',
    'si'=>'පන්ති ',
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

@section('style')

<style>
  .profile-section {
    margin: 30px 43px 0;
}
</style>

@endsection

@section('content')

    @include('blocks.aside')



    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      @include('blocks.nav')

        <div class="container mt-5">
            <h2 class="mb-4">{{$QA['test']['name']}}</h2>
            <h3>Questions - {{$QA['QA']->count()}}</h3>
            <form action="{{route('classes.test.submit',$QA['test']['id'])}}" method="post">
                <input type="hidden" name="test_id" value="{{$QA['test']['id']}}">
                <input type="hidden" name="class_id" value="{{$class_id}}">
                @csrf

                @foreach($QA['QA'] as $key => $question)

                    <div class="card mb-3">
                        <div class="card-header">
                            <strong>{{$key+1}}. {{$question->question}}</strong>
                        </div>


                        <div class="row align-items-center">
                            <div class="col-lg-8 col-md-12 mb-3">
                                <div class="card-body">

                                    @php
                                        // Collect all available answers
                                        $answers = array_filter([
                                            $question->answer_1,
                                            $question->answer_2,
                                            $question->answer_3,
                                            $question->answer_4,
                                            $question->answer_5
                                        ]);

                                        // Shuffle the answers
                                        shuffle($answers);
                                    @endphp

                                    @foreach($answers as $index => $answer)
                                        @if($answer != 'null')
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" required @if(old('q'.$question->id) == $answer) checked @endif name="q{{ $question->id }}" id="q{{ $question->id }}a{{ $index+1 }}" value="{{ $answer }}">
                                                <label class="form-check-label" for="q{{ $question->id }}a{{ $index+1 }}">
                                                    {{ $answer }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12 text-center">
                                @if($question->image != 0)
                                    <img
                                        src="{{ asset($question->image) }}"
                                        alt="Question Image"
                                        class="img-fluid"
                                        style="max-height: 200px; object-fit: cover;">
                                @endif
                            </div>
                        </div>


                    </div>

                @endforeach

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100">Submit Answers</button>
            </form>
        </div>




    </main>



@endsection
