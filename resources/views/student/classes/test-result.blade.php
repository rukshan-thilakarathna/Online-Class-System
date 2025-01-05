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
            <h3>Questions - {{$QA['QA']->count()}} - Result</h3>

            @php
                
                $test = \App\Models\StudentHasTest::where('test_id', $QA['test']['id'])->where('student_id', session()->get('user_id'))->first();
    
            @endphp

            <div>
                <p>Marks : <span class="text-success">{{$test['get_marks']}}</span></p>
                <p>Pracntage : <span class="text-success">{{$test['marks_percentage']}}%</span></p>
                <p>Rank : <span class="text-success">{{$test['status']}}</span></p>
            </div>
            
                <input type="hidden" name="test_id" value="{{$QA['test']['id']}}">
                
                @foreach($QA['QA'] as $key => $question)

                    @php
                        $result = \App\Models\testMarkingHistory::where('Qanda_id', $question->id)->where('student_id', session()->get('user_id'))->first();
                    @endphp

                    <div class="card mb-3">
                        <div class="card-header">
                            <strong>{{$key+1}}. {{$question->question}}</strong>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-lg-8 col-md-12 mb-3">
                                <div class="card-body">

                                    @php
                                        $answers = array_filter([
                                            $question->answer_1,
                                            $question->answer_2,
                                            $question->answer_3,
                                            $question->answer_4,
                                            $question->answer_5
                                        ]);

                                        shuffle($answers);
                                    @endphp

                                    @foreach($answers as $index => $answer)
                                        @if($answer != 'null')
                                            <div class="form-check">
                                                <input readonly class="form-check-input" type="radio" required @if($result->student_answer == $answer) checked @endif name="q{{ $question->id }}" id="q{{ $question->id }}a{{ $index+1 }}" value="{{ $answer }}">
                                                <label  @if ($result->Correct_answer == $answer)
                                                    style="background: green;padding: 5px;color: white;"
                                                @endif  
                                                
                                                @if ($result->Correct_answer != $answer && $result->student_answer == $answer)
                                                    style="background: red;padding: 5px;color: white;"
                                                @endif
                                                
                                                class="form-check-label" for="q{{ $question->id }}a{{ $index+1 }}">
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

        </div>




    </main>



@endsection
