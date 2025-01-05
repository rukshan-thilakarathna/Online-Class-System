<div style="margin-top: 50px">
    @foreach ($questions as $key => $question)
        <div class="zd1" @if ($question->status == 0)style="background: #ffd6d6;" @else style="background: white;"@endif>
            <h5 class="zh21" >0{{$key+1}}). {{$question->question}} </h5>
            <div>
                <img style="height: 295px;" src="{{$question->image}}" alt="">
            </div>
            <ol class="zu1">
                @if ($question->answer_1 != 'null')<li class="zl1" @if ($question->answer_1 == $question->correct_answer)style="color: green;"@endif>{{$question->answer_1}}</li>@endif
                @if ($question->answer_2 != 'null')<li class="zl1" @if ($question->answer_2 == $question->correct_answer)style="color: green;"@endif>{{$question->answer_2}}</li>@endif
                @if ($question->answer_3 != 'null')<li class="zl1" @if ($question->answer_3 == $question->correct_answer)style="color: green;"@endif>{{$question->answer_3}}</li>@endif
                @if ($question->answer_4 != 'null')<li class="zl1" @if ($question->answer_4 == $question->correct_answer)style="color: green;"@endif>{{$question->answer_4}}</li>@endif
                @if ($question->answer_5 != 'null')<li class="zl1" @if ($question->answer_5 == $question->correct_answer)style="color: green;"@endif>{{$question->answer_5}}</li>@endif
            </ol>

            <div class="zd2" style="align-items: center">
               
                {!!  Orchid\Screen\Actions\Link::make(__('Update'))
                    ->style('background: #0c616e; color: white;text-decoration: none;')
                    ->route('platform.systems.test.questions&answers-update', $question->id);
                !!}

                <div >
                    <span style="font-weight: bold">Time</span> : {{$question->time}} minites
                </div>

                <div >
                    <span style="font-weight: bold">Marks</span>: {{$question->marks}} 
                </div>

            </div>   
        </div>
    @endforeach

    

   


</div>