@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$questionnaire->title}}</div>

                <div class="card-body">
                    <form action="/questionnaires" method="post">
                    <a class="btn btn-dark" href="/questionnaires/{{$questionnaire->id}}/questions/create">Add new question</a>
                    <a class="btn btn-dark" href="/surveys/{{ $questionnaire->id }}-{{ Str::slug($questionnaire->title) }}">Take Survey</a>
                    <a type="button" class="btn btn-outline-danger" id="submitForm" onclick="delete_question()" data-toggle="modal" data-target="#locModal">Delete Question</a>
                  
                </div>
            </div>

            @foreach ($questionnaire->questions as $question)
                <div class="card mt-4">
                    
                    
                    <div class="card-header"> 
                        <span><input type="checkbox" name="cId" onclick="setQuestionId({{$question->id}})" class="checkBoxClass" value="{{$question->id}}" /> <span>{{ $question->question }}
                    </div>
                      
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($question->answers as $answer)
                                <li class="list-group-item d-flex justify-content-between">
                                    <div>{{ $answer->answer}} </div>
                                    @if($question->responses->count())
                                    <div>{{intval( ($answer->responses->count() * 100 / $question->responses->count()))}}%</div>
                                    @endif
                                </li>
                            @endforeach                                    
                        </ul>
                    </div>
                </div>
            @endforeach

            <div class="modal fade" id="locModal" tabindex="-1" role="dialog" aria-labelledby="locModalLabel" aria-hidden="true">

                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="locModalLabel">Are you sure you want to delete the question?</h5>
                        </div>
                    
                        <div class="modal-footer">
                            <button id="w-change-close" type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <button id="w-change-btn" type="button" onclick="delete_question()" class="btn btn-primary">Yes</button>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" defer>

    var locModal = document.getElementById('locModal');
    var btnclose = document.getElementById('w-change-close');
    var btnShow= document.getElementById('w-change-location');

    var questionId = [];

        btnclose.addEventListener('click', (e) => 
        {
            locModal.style.display = "none";
            locModal.classList.remove('show');
        });

    document.addEventListener('click', function (event) {

    if (!event.target.matches('.click-me')) return;

    event.preventDefault();

    console.log(event.target);

    }, false);

    function getQuestionId(){
        return questionId
    }

    function setQuestionId(id){
        // alert(id)
        
        if (questionId.includes(id)) {
            let index = questionId.findIndex(i=>i == id)
            questionId = questionId.splice(index, 1)
        } else {
            questionId.push(id)
        }
       
    }

    function delete_question(){
        const element = document.getElementById('submitForm');
        var csrf = document.querySelector('meta[name="csrf-token"]').content;

        fetch('http://127.0.0.1:8000/delete_questionnaires', 
        {
            method: 'POST', 
            credentials: "same-origin",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrf
            },
            body: JSON.stringify({
                id: questionId
            })
        }).then(response => {
                    return response.json();
                }).then(text => {
                    location.reload()
                    return console.log(text);
                }).catch(error => console.log(error));

    }

</script>

@endsection

