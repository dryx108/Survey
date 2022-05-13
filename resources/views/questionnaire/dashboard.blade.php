@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

      

        <div class="row">
            <div class="col-md-4">
                <canvas id="myChart1"></canvas>
            </div>
            <div class="col-md-4">
                <canvas id="myChart"></canvas>
            </div>
            <div class="col-md-4">
                <select id="questionnaire" onchange="getQuestion()">
                    @foreach($questionnaires as $questionnaire)
                        <option value="{{ $questionnaire->id}}">{{$questionnaire->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
</div>
<script src="{{ asset('chart.js/chart.js') }}"></script>
<script type="text/javascript">


function getQuestion(){

        var questionnaire_id = document.getElementById("questionnaire").value;
      
        var csrf = document.querySelector('meta[name="csrf-token"]').content;

        fetch(`${location.origin}/questions?questionnaire_id=${questionnaire_id}`, 
        {
            method: 'GET', 
            credentials: "same-origin",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrf
            },
            // body: JSON.stringify({
            //     id: questionnaire_id
            // })
        }).then(response => {
            
                    return response.json();
                }).then(text => {
                   console.log('response', text)
                }).catch(error => console.log(error));

    }
    getQuestion(1)
  
  
  const data = {
  labels: [
    'Very Satisfied',
    'Satisfied',
    'Neutral',
    'Dissatisfied'
  ],
  datasets: [{
    label: 'My First Dataset',
    data: [
      40,20,40,10

    ],
    backgroundColor: [
      'rgb(255, 99, 132)', 
      'rgb(54, 162, 235)',
      'rgb(255, 205, 86)',
      'rgb(0, 0, 0)'
    ],
    hoverOffset: 5
  }]
};

  const config = {
  type: 'pie',
  data: data,
};

const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );

  // const myChart1 = new Chart(
  //   document.getElementById('myChart1'),
  //   config
  // );

</script>
@endsection

