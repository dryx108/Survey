@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        <h1>{{ $questionnaire->title }}</h1>

        <form action="/surveys/{{ $questionnaire->id}}-{{ Str::slug($questionnaire->title) }}" method="post">

            @csrf

            @foreach($questionnaire->questions as $key => $question)
            <div class="card mt-4">
                <div class="card-header"><strong>{{ $key +1 }}</strong> {{ $question->question }}</div>

                <div class="card-body">

                    @error('responses.' . $key . '.answer_id')  
                        <small class="text-danger">{{ $message }}</small>

                        
                    @enderror

                <ul class="list-group">
                    @foreach($question->answers as $answer)
                    <label for="answer{{ $answer->id}}">
                    <li class="list-group-item">
                <input type="radio" name="responses[{{ $key}}][answer_id]" id="answer{{ $answer->id }}"
                {{(old('responses.' . $key . '.answer_id')== $answer->id) ? 'checked': ''}}
                class="mr-2" value="{{ $answer->id }}">
                    {{ $answer->answer}}

                <input type="hidden" name="responses[{{ $key }}][question_id]" value="{{ $question->id}}">     
                    </li>
                </label>
                @endforeach
                                    
         </ul>
        </div>
    </div>
            @endforeach


            <div class="form-group">
                <label for="name">Your Name</label>
                <input name="name" type="text" class="form-control" id="name" aria-describedby="nameHelp"
                 placeholder="Enter Name">
                <small id="nameHelp" class="form-text text-muted">Enter Your Name.</small>

                @error('name')
                <small class="text-danger">{{$message}}</small>
                    
                @enderror
              </div>
            
              <div class="form-group">
                <label for="email">Your Email</label>
                <input name="email" type="email" class="form-control" id="email" 
                aria-describedby="emailHelp" placeholder="Enter Email">
                <small id="emailHelp" class="form-text text-muted">Give Your Email Please Master!.</small>
            
                @error('email')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>


        <button class="btn btn-dark" type="submit">Complete Survey</button>


        </form>
            {{-- <div class="card">
                <div class="card-header">Create New Questinnaire</div>

                <div class="card-body">
                   <form action="#" method="post">

                    @csrf
                    <div class="form-group">
                        <label for="question">Question</label>
                        <input name="question[question]" type="text" class="form-control"
                        value="{{old('question.question')}}" id="question" 
                        aria-describedby="questionHelp" placeholder="Enter Question">
                        <small id="questionHelp" class="form-text text-muted">Enter Your Question.</small>

                        @error('question.question')
                        <small class="text-danger">{{$message}}</small>
                            
                        @enderror
                      </div>
                    
                      <div class="form-group">
                        <fieldset>
                            <legend>Choices</legend>
                            <small id="choicesHelp" class="form-text text-muted">Enter Your Choices.</small>
                            
                            <div>
                                <div class="form-group">
                                    <label for="answer1">Choice 1</label>
                                    <input name="answers[][answer]" type="text" 
                                    value="{{old('answers.0.answer')}}" 
                                    class="form-control" id="answer1" aria-describedby="choiceHelp"
                                         placeholder="Enter Choice 1">
            
                                    @error('answers.0.answer')
                                    <small class="text-danger">{{$message}}</small>
                                        
                                    @enderror
                                  </div>
                                
                            </div>

                            <div>
                                <div class="form-group">
                                    <label for="answer2">Choice 2</label>
                                    <input name="answers[][answer]" type="text"
                                    value="{{old('answers.1.answer')}}"  
                                    class="form-control" id="answer2" aria-describedby="choiceHelp" placeholder="Enter Choice 2">
            
                                    @error('answers.1.answer')
                                    <small class="text-danger">{{$message}}</small>
                                        
                                    @enderror
                                  </div>
                                
                            </div>

                            <div>
                                <div class="form-group">
                                    <label for="answer3">Choice 3</label>
                                    <input name="answers[][answer]" type="text"
                                    value="{{old('answers.2.answer')}}"  
                                    class="form-control" id="answer3" aria-describedby="choiceHelp" placeholder="Enter Choice 3">
            
                                    @error('answers.2.answer')
                                    <small class="text-danger">{{$message}}</small>
                                        
                                    @enderror
                                  </div>
                                
                            </div>  
                            
                                    
                            <div>
                                <div class="form-group">
                                    <label for="answer4">Choice 4</label>
                                    <input name="answers[][answer]" type="text"
                                    value="{{old('answers.3.answer')}}"  
                                    class="form-control" id="answer4" aria-describedby="choiceHelp" placeholder="Enter Choice 4">
            
                                    @error('answers.3.answer')
                                    <small class="text-danger">{{$message}}</small>
                                        
                                    @enderror
                                  </div>
                                
                            </div>  
                                    

                            
                        </fieldset>
                      </div>
                    
                      <button type="submit" class="btn btn-primary">Add Questtion</button> --}}
                
                {{-- </div>
            </div> --}}
        </div>
    </div>
</div>
@endsection