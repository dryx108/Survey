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
        // dd($questionnaire->toArray());
        return view('question.create', compact('questionnaire'));
    }

    public function store(Questionnaire $questionnaire)
    {
        
        $data = request()->validate([
            'question.question' => 'required',
            'answers.*.answer' => 'required',
        ]);

        //  dd($data['question']);

        $question = $questionnaire->questions()->create($data['question']);
        $question->answers()->createMany($data['answers']);

        return redirect('/questionnaires/'.$questionnaire->id);
    }


public function destroy(Request $question)
{

    // $question->answers()->delete();
    // $question->delete();

    // dd($question);
    
// dd($questionnaire->toArray());
   return response()->json([
       'data'=> Question::find($question->id)->delete()
   ],200);
}

}