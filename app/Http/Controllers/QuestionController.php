<?php

namespace App\Http\Controllers;
// use App\Models\Questions;
use App\Models\{Questionnaire, Question};
// use App\Http\Controllers\Questionnaire;
use Illuminate\Http\Request;


class QuestionController extends Controller
{
        public function create(Questionnaire $questionnaire)

    {
        
        return view('question.create', compact('questionnaire'));
    }

        public function store(Questionnaire $questionnaire)
    {
        
        $data = request()->validate([
            'question.question' => 'required',
            'answers.*.answer' => 'required',
        ]);


        $question = $questionnaire->questions()->create($data['question']);
        $question->answers()->createMany($data['answers']);

        return redirect('/questionnaires/'.$questionnaire->id);
    }


public function destroy(Request $question)
{


    Question::whereIn('id', $question->toArray()['id'])->delete();


    return response()->json([
       'message'=> 'Deleted Successfully'
    ],200);
}

public function getQuestion()
{
    return Question::with(['responses'])->where('questionnaire_id', request('questionnaire_id'))->get();

}

}