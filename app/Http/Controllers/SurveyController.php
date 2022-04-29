<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use Illuminate\Http\Request;
use App\Models\Survey;

class SurveyController extends Controller
{
    public function show(Questionnaire $questionnaire, $slug)

    {
     $questionnaire->load('questions.answers');
     return view('survey.show', compact('questionnaire'));

    }

    public function store(Questionnaire $questionnaire)
    {
        

        $data = request()->validate([
            'responses.*.answer_id' => 'required',
            'responses.*.question_id' => 'required',
            'name' => 'required',
            'email' => 'required',
        ]);
        // dd($data);
        
        $survey = $questionnaire->surveys()->create([
            'name'=>$data['name'],
            'email'=>$data['email'],
        ]);
        $survey->responses()->createMany($data['responses']);
       
        return 'Thank you!';
        
    }
}
