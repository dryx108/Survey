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
                </div>
            </div>

            @foreach ($questionnaire->questions as $question)
                <div class="card mt-4">
                    <div class="card-header">{{ $question->question }}</div>

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

                    <div class="card-footer">
                        <button id="w-change-location" type="button" data-toggle="modal" data-target="#locModal" id="submitForm" onclick="setQuestionId({{$question->id}})" class="btn btn-sm btn-outline-danger"> Delete Question </button>
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
{{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
<script type="text/javascript">
// document.addEventListener("DOMContentLoaded", function() {
    var locModal = document.getElementById('locModal');
    var btnclose = document.getElementById('w-change-close');
    var btnShow= document.getElementById('w-change-location');

    var questionId = null

    //show the modal
    btnShow.addEventListener('click', (e) => {
        locModal.style.display = "block";
        locModal.style.paddingRight = "17px";
        locModal.classList.add('show'); 
    });
        //hide the modal
        btnclose.addEventListener('click', (e) => {
            locModal.style.display = "none";
            locModal.classList.remove('show');
    });
    // window.onload=function(){
    // $('#deleteForm').submit(function(e){
    //     e.preventDefault()
    // })
    // }

    // document.addEventListener('DOMContentLoaded', function(){
    //     var form=document.getElementById('deleteForm')
    //     // console.log (form)
    //     form.addEventListener('submit',function(e){
    //         e.preventDefault();
    //         test()
    //     })
    //     function test(){
    //         console.log('asdasdasd')
    //     }
    // },false)

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
            questionId = id
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
    // fetch('https://reqres.in/api/posts/1', { method: 'DELETE' })
    //     .then(() => element.innerHTML = 'Delete successful');

// });

</script>

@endsection

