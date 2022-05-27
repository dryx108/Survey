@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

      

        <div class="row">
            {{-- <div class="col-md-4">
                <canvas id="myChart1"></canvas>
            </div> --}}
            <div class="col-md-8">
              <div id="myChartContent">
                <canvas name='myChart'></canvas>
            </div>
            </div>
            {{-- <div>
              {{$questionnaires}}
            </div> --}}
            <div class="col-md-4">
                <select id="questionnaire" onchange="getQuestion()">
                    @foreach($questionnaires as $questionnaire)
                        <option value="{{ $questionnaire->id}}">{{$questionnaire->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
</div>


{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js" ></script> --}}
<script src="{{ asset('chart.js/chart.js') }}"></script>

<script type="text/javascript">
 

  var myChart = null
 var ctx = null
var question_as_label = []
var chartId = '0'
var datasets = [{
      label: 'Very Satisfied',
      backgroundColor: "#000080",
      data: []
    }, {
      label: 'Satisfied',
      backgroundColor: "#d3d3d3",
      data: []
    }, {
      label: 'Neutral',
      backgroundColor: "#add8e6",
      data: []
    },{
      label: 'Dissapointed',
      backgroundColor: "#161717",
      data: []
    }]
var labels = []
    getQuestion()
  
 function getQuestion(){
         var questionnaire_id = document.getElementById("questionnaire").value;
      // console.log(questionnaire_id)
      // ctx = document.getElementById(questionnaire_id)
      chartId = questionnaire_id
        var csrf = document.querySelector('meta[name="csrf-token"]').content;

        fetch(`${location.origin}/questions?questionnaire_id=${questionnaire_id}`, 
        {
            method: 'GET', 
            credentials: "same-origin",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrf
            },

        }).then(response => {
            
                    return response.json();
                }).then(response => {
                  console.log('response test', response)
                  question_as_label = response.map(l=>l.question)
                  console.log('question', question_as_label)
                  // var a = 0
                  // var b = 0
                  // var c = 0
                  // var d = 0

                  datasets[0].data=[]
                  datasets[1].data=[]
                  datasets[2].data=[]
                  datasets[3].data=[]
                  response.forEach(e => {
                    console.log('response item', e)
                    // e.responses.forEach(er => {
                    //   console.log('asd',er)
                    
                    // })
                      // e.responses.forEach(i => {
                        // console.log('item',i)
                        
                        a = e.responses.filter(i => i.answer.answer == 'Very Satisfied').length
                        b = e.responses.filter(i => i.answer.answer == 'Satisfied').length
                        c = e.responses.filter(i => i.answer.answer == 'Neither satisfied nor dissatisfied').length
                        d = e.responses.filter(i => i.answer.answer == 'Dissatisfied').length
                        datasets[0].data.push(a)
                        datasets[1].data.push(b)
                        datasets[2].data.push(c)
                        datasets[3].data.push(d)
                    
                        
                    } )
                  // })
                  // test = response.map(e => e.responses)
                  
                  console.log('test',questionnaire_id)
                  document.getElementsByName('myChart')[0].id = questionnaire_id
                 buildChart(datasets, questionnaire_id)
                   
                }).catch(error => console.log(error));

    }
  

    console.log(question_as_label)


    function buildChart(dataset, id)
    {
      const data =  {
        labels: question_as_label,
        datasets: dataset
      };
      var options= {
          legend: {
            display: true,
            position: 'top',
            labels: {
              fontColor: "#000080",
            }
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      //   const config = {
      //   type: 'bar',
      //   data: data,
      //   options:options

      // };

      console.log(id)
      document.getElementById(id)
       ctx = document.getElementById(id)
      //  $('#1').replaceWith($('<canvas id="canvas" height="320px"></canvas>'));
      // ctx.id = id
      

      // myChart.clear()
      myChart?.destroy();
     myChart = new Chart(ctx, {type: 'bar', data:data, options:options});
      
      
    // myChart.destroy();
    // myChart = new Chart(id.toString(), {type: 'bar', data:data, options:options});
    // const myChart = new Chart(
    //     document.getElementById('myChart'),
    //     config
    //   );
      
  }
  function destroyChart() {
    window.myChart.destroy();
  }
  // getQuestion(1)
function randomId() { 
  chartId = (Math.floor(Math.random() * 90000) + 10000).toString()
  console.log(chartId)
  document.getElementById('1').id=chartId
}
//   const data = {
//   labels: [
//     "Very Satisfied", "Satisfied", "Neutral", "Dissatisfied"
//   ],
//   datasets: [{
//     label: 'My First Dataset',
//     data: [
//       40,20,40,10

//     ],
//     backgroundColor: [
//       'rgb(255, 99, 132)', 
//       'rgb(54, 162, 235)',
//       'rgb(255, 205, 86)',
//       'rgb(0, 0, 0)'
//     ],
//     hoverOffset: 5
//   }]
// };

//   const config = {
//   type: 'pie',
//   data: data,
// };

// const myChart = new Chart(
//     document.getElementById('myChart'),
//     config
//   );

</script>
@endsection
