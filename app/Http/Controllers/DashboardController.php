<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questionnaire;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('questionnaire.dashboard')->with('questionnaires', Questionnaire::all());
    }

}
