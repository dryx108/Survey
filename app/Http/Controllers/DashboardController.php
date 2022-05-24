<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questionnaire;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $asd =  Questionnaire::with(['surveys' => function ($q) { $q->with('responses'); } ])->get();
        return view('questionnaire.dashboard')->with('questionnaires',$asd);
    }

}
